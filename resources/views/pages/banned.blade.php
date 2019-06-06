@extends('layouts.app')

@section('pageTitle', 'Banned')

@section('content')
<br />
<br />
<div class="ml-4 mr-4 mt-5 text-center standard-text items-centered-vertical fullscreen-3-4">
    <div class="row align-bottom">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-4 align-self-center">
            <h2>Stop! This account has been banned!</h2>
            <p class="stop"><i class="fas fa-ban"></i></p>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 align-self-center">
            <h4>Ban Details</h4>
            <div class="row mb-4 ml-4 mr-4">
                <p>Banned User: {{ $user->name }};
            </div>
            <div class="row mb-4 ml-4 mr-4">
                <p>Banned by: {{ $admin->name }};
            </div>
            <div class="row mb-4 ml-4 mr-4">
                <p>Banned because: {{ $ban->motive }};
            </div>
            <div class="row mb-4 ml-4 mr-4">
                <p>Banned until: {{ $ban->date }};
            </div>
            <form method="GET" action="{{ route('logout') }}">
                <button type="submit" class="btn btn-dark">Log out</button>
            </form>
        </div>
    </div>
</div>
@endsection