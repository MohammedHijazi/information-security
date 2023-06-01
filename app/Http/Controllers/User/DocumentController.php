<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    protected $path= 'user.document';
    public function index()
    {
        $doc_ids= Permission::where(['user_id'=> auth()->id(), 'permission'=> 'read'])->pluck('document_id');
        $documents= Document::orderByDesc('created_at')->where('user_id', \auth()->id())->orWhereIn('id', $doc_ids)->get();
        return view($this->path.'.index',compact('documents'));
    }
    public function create()
    {
        $document= null;
        return view($this->path.'.form_page', compact('document'));
    }
    public function store(Request $request)
    {
        $request->flashOnly(['name']);
        $validation= Validator::make(
            $request->all(),[
            'name'=>'required|string|max:255',
            'file'=>'required|mimetypes:text/plain',
            'security_level'=>'required|string|in:top_secret,secret,confidential,unclassified',
        ],[],[]
        );
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());
        }
        try {
            $file_name= time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move(Storage::disk('public')->path('/files'),$file_name);
            Document::create([
                'name'=> $request->name,
                'security_level'=> $request->security_level,
                'file_path'=> '/files/'.$file_name,
                'user_id'=> auth()->user()->user_type == "user" ? auth()->id() : null
            ]);
            // all good
            return redirect()->route('document.index')->with(['success'=>'The document added successfully']);
        } catch (\Exception $e) {
            // something went wrong
            dd($e);
            return redirect()->back()->with(['error'=>'Error']);
        }

    }
    public function edit($id)
    {
        $document= Document::whereId($id)->first();
        if($document->user_id == \auth()->id()){
            return view($this->path.'.form_page',compact('document'));
        }
        return "You don't have permission for this action";
    }
    public function update(Request $request, $id)
    {
        $request->flashOnly((['name','email']));
        $validation= Validator::make(
            $request->all(),[
            'name'=>'required|string|max:255',
            'security_level'=>'required|string|in:top_secret,secret,confidential,unclassified',
        ],[],[]
        );

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());
        }
        try {
            $document= Document::whereId($id)->first();
            if(!($document->user_id == auth()->id())){
                return "You don't have permission for this action";
            }
            $document->update([
                'name'=> $request->name,
                'security_level'=> $request->security_level,
            ]);
            Storage::disk('public')->put($document->file_path, $request->content);

            return redirect()->route('document.index')->with(['success'=>'Updated Successfully']);
        } catch (\Exception $e) {
            // something went wrong
            return redirect()->back()->with(['error'=>'something went wrong']);

        }
    }
    public function destroy($id)
    {
        try {

            $document= Document::whereId($id)->first();
            if (Storage::disk("public")->exists($document->file_path)){
                Storage::disk("public")->delete($document->file_path);
            }
            $document->delete();
            // all good
            return redirect()->back()->with(['success'=>'Deleted Successfully']);

        } catch (\Exception $e) {
            // something went wrong
            return redirect()->back()->with(['error'=>'Error']);
        }

    }

    public function permission_form($document_id){
        $document= Document::whereId($document_id)->first();
        $users= User::where('user_type','user')->where('id', '!=', $document->user_id)->where('security_level', $document->security_level)->get();
        if(!($document->user_id == auth()->id())){
            return "You don't have permission for this action";
        }
        return view($this->path.'.permission_form',compact('users','document'));
    }

    public function permission_post(Request $request,$document_id){
        $validation= Validator::make(
            $request->all(),[
            'user'=>'required|numeric',
            'permission'=>'array|min:1',
        ],[],[]
        );

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());
        }
        Permission::where(['user_id'=> $request->user, 'document_id'=> $document_id])->delete();
        foreach ($request->permission as $permission){
            Permission::create(
                [
                    'user_id'=> $request->user,
                    'permission'=> $permission,
                    'document_id'=> $document_id
                ]);
        }
        return redirect()->route('document.index')->with(['success'=>'Add permissions Successfully']);
    }
}
