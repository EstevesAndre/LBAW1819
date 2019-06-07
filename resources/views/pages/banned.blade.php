@extends('layouts.app')

@section('pageTitle', 'Banned')

@section('content')
<br />
<br />
<div class="m-4 text-center standard-text">
    <h1 class="my-5">Stop! This account has been banned!</h1>
    <div class="row align-bottom items-centered-vertical">
        <div class="col-12 col-sm-6 mt-4">
            <div class="stop my-4"><i class="fas fa-ban"></i></div>
        </div>
        <div class="text-left col-12 col-sm-6">
            <h4 class="text-center mb-4"><b>Ban Details</b></h4>
            <p>Banned User: {{ $user->name }}</p>
            <p>Banned by: {{ $admin->name }}</p>
            <p>Banned because: {{ $ban->motive }}</p>
            <p>Banned until: {{ substr($ban->date,0,19) }}</p>
            <form method="GET" class="text-center" action="{{ route('logout') }}">
                <button type="submit" class="btn btn-dark">Log out</button>
            </form>
        </div>
    </div>
</div>
@endsection