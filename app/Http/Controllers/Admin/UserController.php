<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $path= 'dashboard.user';
    public function index()
    {
        $users= User::userType()->orderByDesc('created_at')->get();
        return view($this->path.'.index',compact('users'));
    }
    public function create()
    {
        $user= null;
        return view($this->path.'.form_page',compact('user'));
    }
    public function store(Request $request)
    {
        $request->flashOnly(['name','email']);
        $validation= Validator::make(
            $request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255',
            'password'=>'required|string|max:255',
            'security_level'=>'required|string|in:top_secret,secret,confidential,unclassified',
        ],[],[]
        );
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());
        }
        try {
            User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'security_level'=> $request->security_level,
                'password'=> Hash::make($request->password),
                'user_type'=> "user",
            ]);
            // all good
            return redirect()->route('user.index')->with(['success'=>'The user added successfully']);
        } catch (\Exception $e) {
            // something went wrong
            return redirect()->back()->with(['error'=>'Error']);
        }

    }
    public function edit($id)
    {
        $user= User::userType()->whereId($id)->first();
        return view($this->path.'.form_page',compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->flashOnly((['name','email']));
        $validation= Validator::make(
            $request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255',
            'security_level'=>'required|string|in:top_secret,secret,confidential,unclassified',
        ],[],[]
        );

        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());
        }
        try {
            $user= User::userType()->whereId($id)->first();
            $user->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'security_level'=> $request->security_level,
                'password'=> $request->password? Hash::make($request->password): $user->password,
            ]);
            // all good
            return redirect()->route('user.index')->with(['success'=>'Updated Successfully']);
        } catch (\Exception $e) {
            // something went wrong
            return redirect()->back()->with(['error'=>'something went wrong']);

        }
    }
    public function destroy($id)
    {
        try {

            $user= User::userType()->whereId($id)->first();
            $user->delete();
            // all good
            return redirect()->back()->with(['success'=>'Deleted Successfully']);

        } catch (\Exception $e) {
            // something went wrong
            return redirect()->back()->with(['error'=>'Error']);
        }

    }
}
