<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\UserSessionChanged;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\LoginUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function loginForm(){
        if(Auth::check()){
            if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
                return redirect()->route('admin.publisher.profile');
            }
            return redirect()->route('admin.user.profile');
        }
        return view('admin.auth.login');
    }

    
    public function login(Request $request){
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            LoginUser::create([
                'user_id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]);
            if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
                return redirect()->route('admin.publisher.profile');
            }
            return redirect()->route('admin.user.profile');
        }

        if(User::where('email', $request->email)->first()){
            return back()->withErrors([
                'message' => __('Your password is incorrect.'),
            ]);
        }
        return back()->withErrors([
            'message' => __('The provided credentials do not match our records.'),
        ]);
    }

    public function loginAs($userId){

        Auth::loginUsingId($userId);

        if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
            return redirect()->route('admin.publisher.profile');
        }
        return redirect()->route('admin.user.profile');
    
    }

    public function forgotPassword(Request $request){
        $request->validate([
            'email' => 'required|exists:users,email'
        ]);
        $code = rand(11111, 99999);
        Mail::to($request->email)->send(new ResetPassword($code));
        session(['reset_password_code' => $code, 'email' => $request->email]);
        return redirect()->route('admin.reset.password.form');
    }

    public function resetPasswordForm(){
        if(Auth::check()){
            if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
                return redirect()->route('admin.publisher.profile');
            }
            return redirect()->route('admin.user.profile');
        }
        return view('admin.auth.reset-password');
    }

    public function resetPassword(Request $request){
        if(session('reset_password_code') && session('email') && session('reset_password_code') == $request->code){
            $request->validate([
                'code' => 'required',
                'password' => ['required','confirmed', 'min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/']
            ]);

            $user = User::whereEmail(session('email'))->first();
            if(!$user){
                return redirect()->route('admin.forgot.password')->withErrors('This email dosne`t exists');
            }
            $user->password = Hash::make($request->password); 
            $user->save();
            return redirect()->route('admin.login.form');
        }
        return redirect()->back()->withErrors('This code dosne`t corret');
    }



    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
