@extends('layouts.app')

@section('content')
<br />
<br />
<div class="ml-4 mr-4 mt-5 text-center standard-text items-centered-vertical fullscreen-3-4">
    <div class="row align-bottom">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-4 align-self-center">
            <h2>Motivate yourself to achieve your goals</h2>
            <img src="{{ asset('assets/logo.png') }}" width="50%" alt="icon">
            <h5>Welcome to AlterEgo!!</h5>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 align-self-center">
            <h4>Sign Up For Free</h4>
            <div class="row mb-4 ml-4 mr-4">
                <div class="col-sm-6 col-md-12 col-lg-6 mt-3 mb-3">
                    <button type="button" class="btn-rd btn btn-outline-danger w-100 h-100">Sign up with Google</button>
                </div>
                <div class="col-sm-6 col-md-12 col-lg-6 mt-3 mb-3">
                    <button type="button" class="btn-rd btn btn-outline-primary w-100">Sign up with Facebook</button>
                </div>
            </div>
            <p class="text-left mr-4 ml-4">Username must be 1 to 20 characters, containing only letters a to z,
                numbers 0 to 9, hyphens, or underscores, and cannot include any inappropriate terms.</p>

            <form class="mb-3 ml-4 mr-4" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="username" class="form-control" name="name" id="username" placeholder="Username" required autofocus>
                    @if ($errors->has('username'))
                        <span class="error">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-dark fullsize">Sign Up</button>
            </form>
            <span class="text-center">Already have an AlterEgo account? <a href="{{ url('/login') }}">Login</a></span>
        </div>
    </div>
</div>
<div class="mx-4 mt-5 text-center standard-text">
    <h2>AlterEgo</h2>
</div>
@endsection