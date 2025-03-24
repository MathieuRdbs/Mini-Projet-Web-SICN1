@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('main')
    <form action="{{route('loginpost')}}" method="post">
        @csrf
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row border rounded-5 p-3 bg-white shadow box-area">

                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box p-0" style="background: white; height: 100%;">
                    <div class="featured-image rounded-4 w-100 h-100 d-flex justify-content-center align-items-center" style="overflow: hidden;">
                        <img src="{{ asset('img/logo.jpg') }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
                    </div>
                </div>

                <div class="col-md-6 right-box">
                    <div class="row align-items-center">
                        <div class="header-text mb-4">
                            <h2>Login</h2>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror" placeholder="Email address" value="{{old('email')}}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-5">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6 @error('password') is-invalid @enderror" placeholder="Password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="forgot">
                                <small><a href="#">Forgot Password?</a></small>
                            </div>
                        </div> --}}
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Login</button>
                        </div>
                        <div class="row">
                            <small>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></small>
                        </div>
                     </div>
                </div> 
            </div>
        </div>
    </form>
@endsection