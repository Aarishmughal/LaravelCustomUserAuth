@extends('auth.layouts')
@section('title', 'Dashboard')
@section('content')
    <div class="row mt-5">
        <div class="col-md">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h1 class="display-4">Dashboard</h1>
                </div>
                <div class="card-body p-3">
                    <div class="row my-2">
                        <div class="col">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                            @else
                                <div class="alert alert-success">
                                    You are logged in!
                                </div>
                            @endif
                            <em>If you are seeing this then you are logged in successfully.</em>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Click Here to Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
