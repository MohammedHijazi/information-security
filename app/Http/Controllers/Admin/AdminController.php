<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    protected $path= 'dashboard.admin';
    public function index()
    {
        $administrators= User::adminType()->orderByDesc('created_at')->get();
        return view($this->path.'.index',compact('administrators'));
    }
    public function create()
    {
        $administrator= null;
        return view($this->path.'.form_page',compact('administrator'));
    }
    public function store(Request $request)
    {
        $request->flashOnly(['name','email']);
        $validation= Validator::make(
            $request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255',
            'password'=>'required|string|max:255',
        ],[],[]
        );
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());
        }
        try {
            User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
                'user_type'=> "administrator",
            ]);
            // all good
            return redirect()->route('administrator.index')->with(['success'=>'The administrator added successfully']);
        } catch (\Exception $e) {
            // something went wrong
            return redirect()->back()->with(['error'=>'Error']);
        }

    }
    public function edit($id)
    {
        $administrator= User::adminType()->whereId($id)->first();
        return view($this->path.'.form_page',compact('administrator'));
    }
    public function update(Request $request, $id)
    {
        $request->flashOnly((['name','email']));
        $validation= Validator::make(
            $request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255',
        ],[],[]
        );

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());
        }
        try {

            $administrator= User::adminType()->whereId($id)->first();
            $administrator->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> $request->password? Hash::make($request->password): $administrator->password,
            ]);
            // all good
            return redirect()->route('administrator.index')->with(['success'=>'Updated Successfully']);
        } catch (\Exception $e) {
            // something went wrong
            return redirect()->back()->with(['error'=>'something went wrong']);

        }
    }
    public function destroy($id)
    {
        try {

            $administrator= User::adminType()->whereId($id)->first();
            $administrator->delete();
            // all good
            return redirect()->back()->with(['success'=>'Deleted Successfully']);

        } catch (\Exception $e) {
            // something went wrong
            return redirect()->back()->with(['error'=>'Error']);
        }

    }
}
