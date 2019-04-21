@extends('layouts.app')

<!-- @section('title', $user->name) -->

@section('content')
  <!-- @include('user.card', ['user' => $user]) -->
<br />
<!-- TEST -->
<div class="mt-5 pt-3 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 activity">
        <div class="cardbox-comments d-flex align-items-center">
            <button type="button" class="btn btn-dark mr-2" data-toggle="modal" data-target="#postModal">
                Create a new Post
            </button>
            <div class="search-comment" data-toggle="modal" data-target="#postModal">
                <input placeholder="New publication..." type="text">
            </div>
        </div>
    </div>
</div>
@endsection