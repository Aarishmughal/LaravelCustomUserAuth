<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRegisterController extends BaseController
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'dashboard'
        ]);
    }
    public function register()
    {
        return view('auth.register');
    }
    public function store(Request $request){
        $request->validate([
            "name"=>"required|string|max:250",
            "email"=>"required|email|max:250|unique:users",
            "password"=>"required|min:8|confirmed",
        ],[
            "name.required"=>"Name is required for Registration.",
            "name.string"=>"Name is Invalid.",
            "name.max"=>"Name is too Long.",
            "email.required"=>"Email Address is Required for Registration.",
            "email.email"=>"Email Address is Invalid.",
            "email.max"=>"Email Address is Invalid.",
            "email.unique"=>"User already exists with that Email Address.",
            "password.required"=>"Password is required for Registration.",
            "password.min"=>"Password should be atleast 8 characters long.",
            "password.confirmed"=>"Passwords do not match.",
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        $credentials = $request->only("email","password");
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->withSuccess('You have successfully registered!');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request){
        $credentials = $request->validate([
            "email"=>"required|email|max:250",
            "password"=>"required",
        ],[
            "email.required"=>"Email Address is Required for Authentication.",
            "email.email"=>"Email Address is Invalid.",
            "email.max"=>"Email Address is Invalid.",
            "password.required"=>"Password is required for Authentication.",
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('dashboard')->withSuccess("You have successfully logged in!");
        }else{
            return back()->withErrors([
                "email","Your provided credentials do not match in our records."
            ])->onlyInput('email');
        }
    }
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        } else {
            return redirect()->route("login")->withErrors(['email' => 'Please Login first to access the Dashboard.'])->onlyInput('email');
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("login")->withSuccess("You have successfully logged out!");
    }
}
