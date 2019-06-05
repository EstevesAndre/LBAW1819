@extends('layouts.app')

@section('pageTitle', $search)

@section('content')
<br />
<br />
    <div class="container justify-content-center fullscreen-3-4 my-5">
        <h1><b>Results Found for <u>{{$search}}</u></b></h1><br>
        <div class="d-flex justify-content-center mb-4 mr-3">
            <form class="mb-3 ml-4 mr-4" method="GET" action="/search">
                <div class="searchbar">
                    <input type ="text" class="search_input search_input_fixed" name="search" placeholder="Search..." required>
                    <button type="submit" class="btn btn-dark btn-circle">
                        <div class="search_icon">
                            <i class="fas fa-search"></i>
                        </div>
                    </button>
                </div>
            </form>
        </div>
        <ul class="d-flex justify-content-center mt-3 nav nav-tabs" id="clan-tabs" role="tablist">
            <li class="nav-item">
                <a class="tab-title nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab"
                    aria-controls="users" aria-selected="false">Users</a>
            </li>
            <li class="nav-item">
                <a class="tab-title nav-link" id="posts-tab" data-toggle="tab" href="#posts" role="tab"
                    aria-controls="posts" aria-selected="true">Posts</a>
            </li>
        </ul>
        <div class="mt-4 tab-content" id="leaderboard-content">
           
            <div class="tab-pane fade active show" id="users" role="tabpanel" aria-labelledby="users-tab">
               @if($users->isEmpty())
                <h1><b>No Users Found for {{$search}}</b></h1> 
               @else
                <ul class="pl-0 shadow-lg users-list">
                    @each('partials.searchUsers', $users, 'user')
                </ul>
                <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                @endif
            </div>
            <div class="text-left tab-pane fade border-0 show" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                @if($posts->isEmpty())
                <h1><b>No Posts Found for {{$search}}</b></h1>
                @else 
                <ul class="pl-0 shadow-lg users-list">
                    @each('partials.searchPosts', $posts, 'post')
                </ul>
                <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection