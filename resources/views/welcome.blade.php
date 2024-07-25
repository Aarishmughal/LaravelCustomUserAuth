@extends('auth.layouts')
@section('title', 'Welcome')
@section('content')
    <div class="row mt-5">
        <div class="col-md">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h1 class="display-4">Home Page</h1>
                </div>
                <div class="card-body p-3">
                    <div class="row my-2">
                        <div class="col">
                            <em>If you are seeing this then proceed with Logging in.</em>
                            <a href="{{ Route('login') }}">Click here to Login</a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <em>If you are not registered then register now.</em>
                            <a href="{{ Route('register') }}">Click here to Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
