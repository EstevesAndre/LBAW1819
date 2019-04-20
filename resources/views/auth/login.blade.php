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
                <button type="button" class="btn btn-rd btn-outline-danger w-100 h-100">Login with Google</button>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mt-2 mb-2">
                <button type="button" class="btn btn-rd btn-outline-primary w-100 h-100">Login with
                    Facebook</button>
            </div>
        </div>
        <br />
        <form class="text-left mb-3" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required autofocus>
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
                <div class="text-right mt-1">
                    <a href="#" hh="/pages/passwordRequest.html"><span>Forgot Password?</span></a>
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100 mt-3">Login</button>
        </form>
        <span class="text-center">Don't have an AlterEgo account? <a href="register">Sign Up!</a></span>
    </div>
</div>

@endsection
