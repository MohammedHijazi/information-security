<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Mail\AdminResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserAuth extends Controller
{

    public function login() {

        return view('user.login');
    }
    public function index()
    {
        return view('user.document.index');
    }

    public function dologin() {
        $this->validate(request(),[
            'password'=>'required',
            'email' => 'required',
        ]);
        $rememberme = request('rememberme') == 1?true:false;
        $user= User::where('email', request('email'))->userType()->first();
        if ($user && auth()->attempt(['email' => request('email'), 'password' => request('password')], $rememberme)) {
            return redirect(route('user.home'));
        } else {
            session()->flash('error', 'Make sure the email or password is correct');
            return redirect(route('user.login'));
        }
    }

    public function logout() {
        auth()->logout();
        return redirect(route('user.login'));
    }

    public function forgetPassword(){
        return view('user.forgetPassword');
    }
    public function resetPassword(Request $request){
        $this->validate($request,[
            'email'=>'required',
        ]);
        $user = User::where('email',$request->input('email'))->first();

        if (!empty($user)){
            $token = app('auth.password.broker')->createToken($user);
            DB::table('password_resets')->insert(
                [
                    'email'=>$user->email,
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
            Mail::to($user->email)->send(new AdminResetPassword(['user'=>$user,'token'=>$token]));
            return back()->with(['success'=>'Check your email, password reset link has been sent']);
        }
        return back()->with(['error'=>'Make sure the email is correct']);
    }
    public function resetPasswordWithToken($token){

        $check_token = DB::table('password_resets')
            ->where('token', $token)
            ->where('created_at', '>', Carbon::now()->subHours(2))
            ->first();
        if (!empty($check_token)) {
            return view('user.resetPassword', ['data' => $check_token]);
        } else {
            return redirect(route('user.forgotPassword'));
        }
    }
    public function updatePassword($token){
        $this->validate(request(),[
            'password'=>'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $check_token = DB::table('password_resets')->where('token',$token)
            ->where('created_at','>',Carbon::now()->subHour(2))->first();
        if (!empty($check_token)) {
            $user = User::where('email', $check_token->email)->update([
                'password' => bcrypt(request('password'))
            ]);
            DB::table('password_resets')->where('email',$check_token->email)->delete();
            auth()->attempt(['email' => $check_token->email, 'password' => request('password')]);
                return redirect(route('user.home'));
        } else {
            return redirect(route('user.forgotPassword'));
        }
    }

    public function setting(){
        return view('user.setting');
    }

    public function setting_email(Request $request){
        $this->validate($request,[
           'email'=> 'required|email',
           'new_email'=> 'required|email',
           'email_confirmation'=> 'required|email|same:new_email',
        ],[],[
            'email'=> 'old email',
            'new_email'=> 'new email',
            'email_confirmation'=> 'email confirmation',
        ]);
        if (Auth::user()->email == $request->email){
            Auth::user()->update(['email'=> $request->new_email]);
            return redirect()->back()->with(['success'=> 'The email updated successfully']);
        }
        return redirect()->back()->with(['error'=> 'The old email not correct']);
    }
    public function setting_password(Request $request){

        $this->validate($request,[
            'password'=> 'required|string',
            'new_password'=> 'required|string',
            'password_confirmation'=> 'required|string|same:new_password',
        ],[],[
            'password'=> 'old password',
            'new_password'=> 'new password',
            'password_confirmation'=> 'password confirmation',
        ]);
        if (Hash::check($request->password,Auth::user()->password)){
            Auth::user()->update(['password'=> Hash::make($request->new_password)]);
            return redirect()->back()->with(['success'=> 'The password updated successfully']);
        }
        return redirect()->back()->with(['error'=> 'The old password not correct']);
    }
}
