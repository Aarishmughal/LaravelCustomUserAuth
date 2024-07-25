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
