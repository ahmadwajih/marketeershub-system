<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\UserSessionChanged;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Category;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DigitalAsset;
use App\Models\LoginUser;
use App\Models\Role;
use App\Models\SocialMediaLink;
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
        $accountManagers = User::where('position', 'account_manager')->get();
        return view('new_admin.auth.login');
    }


    public function login(Request $request){
        $request->session()->regenerate();
        //die;
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ]);
        $remember = false;
        if(isset($request->remember_me ) && $request->remember_me == 'on') {
            $remember = true;
        }
        if (Auth::attempt($credentials, $remember)) {
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

    public function registerForm(){
        if(Auth::check()){
            if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
                return redirect()->route('admin.publisher.profile');
            }
            return redirect()->route('admin.user.profile');
        }
        $accountManagers = User::where('position', 'account_manager')->get();
        $countries = Country::get();
        $categories = Category::whereType('influencer')->get();
        $currencies = Currency::get();
        return view('new_admin.auth.register', [
            'accountManagers' => $accountManagers,
            'countries' => $countries,
            'currencies' => $currencies,
            'categories' => $categories
        ]);
    }

    public function register(Request $request){

        $data = $this->validate($request, [
            'name'              => 'required|max:255',
            'email'             => 'required|email|max:255|unique:users,email',
            'phone'             => 'required|unique:users|max:255',
            // 'password'          => ['required','min:8','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'team'              => 'required|in:media_buying,influencer,affiliate,prepaid',
            'account_title'     => 'nullable|max:255',
            'bank_name'         => 'nullable|max:255',
            'bank_branch_code'  => 'nullable|max:255',
            'swift_code'        => 'nullable|max:255',
            'iban'              => 'nullable|max:255',
            'account_manager'   => 'nullable|exists:users,id'
        ]);
        $accountManager = null;
        if($request->account_manager_id){
            $accountManager = $request->account_manager_id ? User::whereId($request->account_manager_id)->first() : null;
        }

        $publisher = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'team' => $request->team,
            'position' => 'publisher',
            'referral_account_manager' => $accountManager ? $accountManager->name : null,
            'parent_id' => $accountManager ? $accountManager->id : null,
            'account_title' => $request->account_title,
            'bank_name' => $request->bank_name,
            'bank_branch_code' => $request->bank_branch_code,
            'swift_code' => $request->swift_code,
            'iban' => $request->iban,
            'address' => $request->address,
            'affiliate_networks' => $request->affiliate_networks,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'currency_id' => $request->currency_id,
            'gender' => $request->gender,
            'years_of_experience' => $request->years_of_experience,
        ]);
        $role = Role::whereLabel('publisher')->first();
        $publisher->assignRole($role);
        $publisher->categories()->sync($request->categories);
        // Store Social Media Accounts
        if($request->team == 'affiliate'){
            if($request->digital_asset && count($request->digital_asset) > 0){
                foreach($request->digital_asset as $link){
                    DigitalAsset::create([
                        'link' => $link['link'],
                        'platform' => $link['platform'],
                        'user_id' => $publisher->id,
                    ]);

                }

            }
        }
        // Store Social Media Accounts
        if($request->team == 'influencer' || $request->team == 'prepaid'){
            if($request->social_media && count($request->social_media) > 0){
                foreach($request->social_media as $link){
                    if(!is_null($link['link'])){
                        SocialMediaLink::create([
                            'link' => $link['link'],
                            'platform' => $link['platform'],
                            'followers' => $link['followers'],
                            'user_id' => $publisher->id,
                        ]);
                    }

                }

            }
        }
        Auth::login($publisher);
        return response()->json($publisher);
        return redirect()->route('admin.publisher.profile');

    }

    public function loginAs($userId){

        Auth::loginUsingId($userId);

        if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
            return redirect()->route('admin.publisher.profile');
        }
        return redirect()->route('admin.user.profile');

    }

    public function forgotPasswordForm(){
        if(Auth::check()){
            if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
                return redirect()->route('admin.publisher.profile');
            }
            return redirect()->route('admin.user.profile');
        }
        return view('new_admin.auth.forgot-password');
    }

    public function forgotPassword(Request $request){
        $request->validate([
            'email' => 'required|exists:users,email'
        ],[
            'email.exists' => 'This email dosn`t exists'
        ]);
        $code = rand(11111, 99999);
        Mail::to($request->email)->send(new ResetPassword($code));
        session(['reset_password_code' => $code, 'email' => $request->email]);
        return response()->json(true, 200);
        // return redirect()->route('admin.reset.password.form');
    }

    public function resetPasswordForm(){
        if(Auth::check()){
            if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
                return redirect()->route('admin.publisher.profile');
            }
            return redirect()->route('admin.user.profile');
        }
        return view('new_admin.auth.reset-password');
    }

    public function resetPassword(Request $request){

        if(session('reset_password_code') && session('email') && session('reset_password_code') == $request->code){
            $request->validate([
                'code' => 'required',
                'password' => ['required','confirmed', 'min:8']
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
