# Custom User Authentication in Laravel

## 1. Setup Laravel Project

Make a new Vanilla Laravel Project using

```sh
laravel new
```

\*_Vanilla means to not use any scaffoldings or starter kits._

## 2. Make Controller

Make a new Controller in `Auth` Namespace in the Controllers Folder by using

```sh
php artisan make:controller Auth/LoginRegisterController
```

## 3. Make Routes

Open the `web.php` file in the **Routes** folder and make required routes

```sh
<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LoginRegisterController::class)->group(
    function () {
        // Route::[requestType]( "[routePath]", "[controllerFunction]")->name("[routeName]");

        //These Routes are for Fetching views and Rendering them
        Route::get("/register", "register")->name("register");
        Route::get("/login", "login")->name("login");
        Route::get("/dashboard", "dashboard")->name("dashboard");

        //These Routes are for handling forms for Registration and Logins
        Route::post("/store","store")->name("store");
        Route::post("/authenticate","authenticate")->name("authenticate");
        Route::post("/logout","logout")->name("logout");
    }
);
```

## 4. Edit the Controller

Open the controller file named `LoginRegisterController.php` in the `Auth` Folder.
**`Extend`** the existing class as follows

```sh
use Illuminate\Routing\Controller as BaseController;

class LoginRegisterController extends BaseController {

#Methods to be placed here

}
```

We first import the Controller class provided by Laravel as `BaseController` in our file, this way we can use the methods as per our need. <br>Next we will make **Methods** starting with the Constructor `__construct()`

#### Constructor Method - `__construct()`

```sh
public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'dashboard'
        ]);
    }
```

#### View Register Form Method - `register()`

```sh
public function register()
    {
        return view('auth.register');
    }
```

#### User Register Method - `store()`

```sh
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
```

#### View Login Form Method - `login()`

```sh
public function login()
    {
        return view('auth.login');
    }
```

#### User Login Method - `authenticate()`

```sh
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
```

#### View Dashboard Method - `dashboard()`

```sh
public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        } else {
            return redirect()->route("login")->withErrors(['email' => 'Please Login first to access the Dashboard.'])->onlyInput('email');
        }
    }
```

#### User Logout Method - `logout()`

```sh
public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("login")->withSuccess("You have successfully logged out!");
    }
```

---

\*_No explaination to these methods as their code is understandable and self-explanitory_

## 5. Make Views

Make a new Folder `auth` in the views folder and make views for our application there. These aren't complete code for view files but important code only for different `laravel gimmicks`

-   Use `@yield('any')` function in **Layout/Template** file as placeholders for content.
-   Use `@content('any','Actual thing here')` function in **Actual Views** files for sending values to Template.
-   Use `@extends('file_name')` function at the Top in your **Actual Views** files to include **Layout/Template** file.
-   Use the code block

```sh
@guest{

#Elements for public URLs placed here

}
@else{

#Elements for private/authorized URLs placed here

}
@endguest
```

in your `Header/Navbar` of your **Layout/Template** file.

-   Render specific rules as per your current **route/request** page by using similar code to

```sh
<a
class="nav-link btn {{ request()->is('login') ? 'btn-dark text-light' : 'btn-light' }}"
href="{{ route('login') }}">Login</a>
#Notice the use of
request()->is('login') #to render specific Bootstrap classes
```

-   Render Logged in User information by using the Methods similar to

```sh
{{ Auth::user()->name }}
```

-   Render Logout buttons/links by using a code block similar to

```sh
<a class="dropdown-item"
href="{{ route('logout') }}"
onclick="event.preventDefault();
document.getElementById('logout-form').submit();"
>Logout</a>

<form id="logout-form"
action="{{ route('logout') }}"
method="POST">
@csrf
</form>
```

-   Render Error Messages sent from the `validate()` method in the Controller file

```sh
@if ($errors->has('email'))
    <span class="text-danger small">
    {{ $errors->first('email') }}</span>
@endif
```

-   Render Error field classes due to validation errors from the `validate()` method by using the following code block

```sh
<input required
type="email" name="email" id="email"
class="form-control
@error('email') is-invalid @enderror"
value="{{ old('email') }}">
```

-   In the above code block, notice the use of the `old()` method to retrieve old input values.
-   In the following code, notice the use of `password_confirmation` as the name of the confirm password input field

```sh
<label for="password_confirmation" class="form-text">Confirm Password<span class="text-danger">*</span></label>
<input type="password" name="password_confirmation" id="password_confirmation"                                    class="form-control @error('password_confirmation') is-invalid @enderror" value="">
```

This is due to the naming scheme in laravel `validate()` method, it expects the name of the confirm password input field to be named `password_confirmation`

-   Render the success messages sent by the `withSuccess()` method in the controller file by using the following code block

```sh
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@else
    <div class="alert alert-success">
        You are logged in!
    </div>
@endif
```
---
By following this guide, this simple yet Robust User Authentication System can be replicated in Laravel.
