@extends('auth.layouts')
@section('title', 'Register')
@section('content')
    <div class="row mt-5">
        <div class="col-md-3"></div>
        <div class="col-md">
            <div class="card shadow-lg">
                <div class="card-header">Register</div>
                <div class="card-body p-3">
                    <form action="{{ Route('store') }}" method="POST">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md">
                                <label for="name" class="form-text">Full Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger small">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md">
                                <label for="email" class="form-text">Email Address<span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger small">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md">
                                <label for="password" class="form-text">Password<span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" value="">
                                @if ($errors->has('password'))
                                    <span class="text-danger small">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md">
                                <label for="password_confirmation" class="form-text">Confirm Password<span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <button class="btn btn-primary" type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center form-text">&#169; Laravel Custom User Auth 2024</div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection
