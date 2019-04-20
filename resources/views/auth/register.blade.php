@extends('layouts.app')

@section('content')
<br />
<br />
<div class="mt-5 ml-4 mr-4 fullscreen-3-4">
    <div class="col-md-6 offset-md-3 text-center">
        <img src="{{ asset('assets/logo.png') }}" width="25%" alt="icon">
        <h2><b>AlterEgo</b></h2>
        <br />
        <div class="row mb-4">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mt-2 mb-2">
                <button type="button" class="btn btn-rd btn-outline-danger w-100 h-100">Sign Up with Google</button>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mt-2 mb-2">
                <button type="button" class="btn btn-rd btn-outline-primary w-100 h-100">Sign Up with Facebook</button>
            </div>
        </div>
        <br />
        <form class="text-left mb-3" method="POST" action="{{ route('register') }}">
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
            <div class="form-group mb-4">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn btn-dark w-100 mt-4">Join AlterEgo</button>
        </form>
        <span class="text-center">Already have an AlterEgo account? <a href="login">Login</a></span>
    </div>
</div>
@endsection
