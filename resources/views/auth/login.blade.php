@extends('layouts.app')

@section('pageTitle', 'Login')

@section('content')
<br />
<br />
<div class="mt-5 ml-4 mr-4 fullscreen-3-4">
    <div class="col-md-6 offset-md-3 text-center">
        <img src="{{ asset('assets/logo.png') }}" class="w-25" alt="icon">
        <h2><b>AlterEgo</b></h2>
        <br />
        <form class="text-left mb-3" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <input type="email" class="form-control mb-2" name="email" id="email" placeholder="Email" required autofocus>
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
            <button type="submit" class="btn btn-dark w-100 mt-3">Login</button>
        </form>
        <span class="text-center">Don't have an AlterEgo account? <a href="register">Sign Up!</a></span>
    </div>
</div>

@endsection
