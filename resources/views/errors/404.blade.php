@extends('layouts.app')

@section('content')
<br />
<br />
<div class="d-flex align-middle align-items-center container mt-5 fullscreen-3-4">
    <div class="bg-white shadow-lg mx-2 pr-4 py-5">
        <div class="row align-items-center">
            <div class="col-sm-12 col-lg-2 text-center">
                <a href="{{ url('/login') }}">
                    <img width="200" class="ml-3 img-fluid border rounded-circle" src="{{ asset('assets/logo.png') }}" alt="logo">
                </a>
            </div>
            <div class="col-sm-12 col-lg-7 my-2 text-left clan-bio">
                <div class="mx-3 text-left basic-info">
                    <h1><b>404 Error</b></h1>
                    <p>The page you're looking for could not be found.</p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-3 my-2 px-1 text-left clan-info">
                <div class="d-flex justify-content-center">
                    <a href="{{ url('/login') }}" class="btn btn-link bg-dark nav-link index-nav">
                        Go Home, You're Drunk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection