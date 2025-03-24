@extends('layouts.auth')

@section('title')
    Register
@endsection

@section('main')
    <form action="{{route('registerpost')}}" method="post">
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
                            <h2>Register</h2>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="fullname" class="form-control form-control-lg bg-light fs-6 @error('fullname') is-invalid @enderror" placeholder="full Name" value="{{old('fullname')}}">
                            
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror" placeholder="Email address" value="{{old('email')}}">
                            
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6 @error('password') is-invalid @enderror" placeholder="Password">
                            
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="phonenumber" class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror" placeholder="Phone number" value="{{old('phonenumber')}}">
                            
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Register</button>
                        </div>
                        <div class="row">
                            <small>Already have account? <a href="{{route("login")}}">Login</a></small>
                        </div>
                     </div>
                </div> 
            </div>
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        </script>
    @endif

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
@endsection     