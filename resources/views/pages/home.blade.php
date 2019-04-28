@extends('layouts.app')

@section('content')
<br />
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
        <!-- Modal -->
        <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postModalLabel">Create Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center w-100 mx-2">
                            <div class="col-sm-12 col-md-4 mt-3">
                                <a href="#"><img width="125" class="img-fluid border rounded-circle mb-3" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE -->
                                <p>André Esteves</p> <!-- CHANGE -->
                            </div>
                            <div class="col-sm-12 col-md-8 pr-5 form-group">
                                <textarea class="form-control text-left mt-3 w-100" rows="6"
                                    placeholder="Write your publication here..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="float-right btn btn-secondary m-3">Add Image</button>
                        <button type="button" class="float-right btn btn-dark my-3">Post</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- POSTS -->
        <section id="posts">
            <div class="container post mt-4 mb-3 p-0">
                <div class="cardbox text-left shadow-lg bg-white">
                    <div class="cardbox-heading">
                        <div class="dropdown float-right mt-3 mr-3">
                            <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                                <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                            </div>
                        </div>
                        <div class="media m-0">
                            <div class="d-flex m-3">
                                <a href=""><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                            </div>
                            <div class="media-body ml-1 align-self-center">
                                <a href=""><p class="text-dark m-0">...</p></a>
                                <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                                <small><span><i class="icon ion-md-time mt-0"></i> ... 10 hours ago</span></small> <!-- CHANGE date -->
                            </div>
                        </div>
                    </div>
                    <div class="cardbox-item mx-3">
                        <p>Hello</p>
                    </div>

                    <!-- Still hardcoded (needs more views and connection to database) -->
                    <div class="cardbox-base">
                        <ul class="mx-3 mb-1">
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning" 
                                        alt="User"></a></li> 
                            <li><a><span>12 Likes</span></a></li>
                        </ul>
                        <ul class="mx-3 mt-2">
                            <li><a href=""><i class="fa fa-comments"></i></a></li>
                            <li><a><em class="mr-5">12</em></a></li>
                            <li><a href=""><i class="fa fa-share-alt"></i></a></li>
                            <li><a><em class="mr-3">03</em></a></li>
                        </ul>
                    </div>
                    <div class="cardbox-comments d-flex align-items-center">
                        <span class="comment-avatar float-left mr-2">
                            <a href=""> 
                                <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                            </a>
                        </span>
                        <div class="search-comment">
                            <input placeholder="Write a comment..." type="text">
                            <button><i class="fas fa-share-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container post mt-4 mb-3 p-0">
                <div class="cardbox text-left shadow-lg bg-white">
                    <div class="cardbox-heading">
                        <div class="dropdown float-right mt-3 mr-3">
                            <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                                <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                            </div>
                        </div>
                        <div class="media m-0">
                            <div class="d-flex m-3">
                                <a href=""><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                            </div>
                            <div class="media-body ml-1 align-self-center">
                                <a href=""><p class="text-dark m-0">...</p></a>
                                <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                                <small><span><i class="icon ion-md-time mt-0"></i> ... 10 hours ago</span></small> <!-- CHANGE date -->
                            </div>
                        </div>
                    </div>
                    <div class="cardbox-item mx-3">
                        <p>Hello</p>
                    </div>

                    <!-- Still hardcoded (needs more views and connection to database) -->
                    <div class="cardbox-base">
                        <ul class="mx-3 mb-1">
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning" 
                                        alt="User"></a></li> 
                            <li><a><span>12 Likes</span></a></li>
                        </ul>
                        <ul class="mx-3 mt-2">
                            <li><a href=""><i class="fa fa-comments"></i></a></li>
                            <li><a><em class="mr-5">12</em></a></li>
                            <li><a href=""><i class="fa fa-share-alt"></i></a></li>
                            <li><a><em class="mr-3">03</em></a></li>
                        </ul>
                    </div>
                    <div class="cardbox-comments d-flex align-items-center">
                        <span class="comment-avatar float-left mr-2">
                            <a href=""> 
                                <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                            </a>
                        </span>
                        <div class="search-comment">
                            <input placeholder="Write a comment..." type="text">
                            <button><i class="fas fa-share-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container post mt-4 mb-3 p-0">
                <div class="cardbox text-left shadow-lg bg-white">
                    <div class="cardbox-heading">
                        <div class="dropdown float-right mt-3 mr-3">
                            <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                                <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                            </div>
                        </div>
                        <div class="media m-0">
                            <div class="d-flex m-3">
                                <a href=""><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                            </div>
                            <div class="media-body ml-1 align-self-center">
                                <a href=""><p class="text-dark m-0">...</p></a>
                                <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                                <small><span><i class="icon ion-md-time mt-0"></i> ... 10 hours ago</span></small> <!-- CHANGE date -->
                            </div>
                        </div>
                    </div>
                    <div class="cardbox-item mx-3">
                        <p>Hello</p>
                    </div>

                    <!-- Still hardcoded (needs more views and connection to database) -->
                    <div class="cardbox-base">
                        <ul class="mx-3 mb-1">
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning" 
                                        alt="User"></a></li> 
                            <li><a><span>12 Likes</span></a></li>
                        </ul>
                        <ul class="mx-3 mt-2">
                            <li><a href=""><i class="fa fa-comments"></i></a></li>
                            <li><a><em class="mr-5">12</em></a></li>
                            <li><a href=""><i class="fa fa-share-alt"></i></a></li>
                            <li><a><em class="mr-3">03</em></a></li>
                        </ul>
                    </div>
                    <div class="cardbox-comments d-flex align-items-center">
                        <span class="comment-avatar float-left mr-2">
                            <a href=""> 
                                <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                            </a>
                        </span>
                        <div class="search-comment">
                            <input placeholder="Write a comment..." type="text">
                            <button><i class="fas fa-share-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container post mt-4 mb-3 p-0">
                <div class="cardbox text-left shadow-lg bg-white">
                    <div class="cardbox-heading">
                        <div class="dropdown float-right mt-3 mr-3">
                            <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                                <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                            </div>
                        </div>
                        <div class="media m-0">
                            <div class="d-flex m-3">
                                <a href=""><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                            </div>
                            <div class="media-body ml-1 align-self-center">
                                <a href=""><p class="text-dark m-0">...</p></a>
                                <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                                <small><span><i class="icon ion-md-time mt-0"></i> ... 10 hours ago</span></small> <!-- CHANGE date -->
                            </div>
                        </div>
                    </div>
                    <div class="cardbox-item mx-3">
                        <p>Hello</p>
                    </div>

                    <!-- Still hardcoded (needs more views and connection to database) -->
                    <div class="cardbox-base">
                        <ul class="mx-3 mb-1">
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning" 
                                        alt="User"></a></li> 
                            <li><a><span>12 Likes</span></a></li>
                        </ul>
                        <ul class="mx-3 mt-2">
                            <li><a href=""><i class="fa fa-comments"></i></a></li>
                            <li><a><em class="mr-5">12</em></a></li>
                            <li><a href=""><i class="fa fa-share-alt"></i></a></li>
                            <li><a><em class="mr-3">03</em></a></li>
                        </ul>
                    </div>
                    <div class="cardbox-comments d-flex align-items-center">
                        <span class="comment-avatar float-left mr-2">
                            <a href=""> 
                                <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                            </a>
                        </span>
                        <div class="search-comment">
                            <input placeholder="Write a comment..." type="text">
                            <button><i class="fas fa-share-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container post mt-4 mb-3 p-0">
                <div class="cardbox text-left shadow-lg bg-white">
                    <div class="cardbox-heading">
                        <div class="dropdown float-right mt-3 mr-3">
                            <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                                <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                            </div>
                        </div>
                        <div class="media m-0">
                            <div class="d-flex m-3">
                                <a href=""><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                            </div>
                            <div class="media-body ml-1 align-self-center">
                                <a href=""><p class="text-dark m-0">...</p></a>
                                <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                                <small><span><i class="icon ion-md-time mt-0"></i> ... 10 hours ago</span></small> <!-- CHANGE date -->
                            </div>
                        </div>
                    </div>
                    <div class="cardbox-item mx-3">
                        <p>Hello</p>
                    </div>

                    <!-- Still hardcoded (needs more views and connection to database) -->
                    <div class="cardbox-base">
                        <ul class="mx-3 mb-1">
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning" 
                                        alt="User"></a></li> 
                            <li><a><span>12 Likes</span></a></li>
                        </ul>
                        <ul class="mx-3 mt-2">
                            <li><a href=""><i class="fa fa-comments"></i></a></li>
                            <li><a><em class="mr-5">12</em></a></li>
                            <li><a href=""><i class="fa fa-share-alt"></i></a></li>
                            <li><a><em class="mr-3">03</em></a></li>
                        </ul>
                    </div>
                    <div class="cardbox-comments d-flex align-items-center">
                        <span class="comment-avatar float-left mr-2">
                            <a href=""> 
                                <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                            </a>
                        </span>
                        <div class="search-comment">
                            <input placeholder="Write a comment..." type="text">
                            <button><i class="fas fa-share-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container post mt-4 mb-3 p-0">
                <div class="cardbox text-left shadow-lg bg-white">
                    <div class="cardbox-heading">
                        <div class="dropdown float-right mt-3 mr-3">
                            <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                                <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                            </div>
                        </div>
                        <div class="media m-0">
                            <div class="d-flex m-3">
                                <a href=""><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                            </div>
                            <div class="media-body ml-1 align-self-center">
                                <a href=""><p class="text-dark m-0">...</p></a>
                                <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                                <small><span><i class="icon ion-md-time mt-0"></i> ... 10 hours ago</span></small> <!-- CHANGE date -->
                            </div>
                        </div>
                    </div>
                    <div class="cardbox-item mx-3">
                        <p>Hello</p>
                    </div>

                    <!-- Still hardcoded (needs more views and connection to database) -->
                    <div class="cardbox-base">
                        <ul class="mx-3 mb-1">
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning" 
                                        alt="User"></a></li> 
                            <li><a><span>12 Likes</span></a></li>
                        </ul>
                        <ul class="mx-3 mt-2">
                            <li><a href=""><i class="fa fa-comments"></i></a></li>
                            <li><a><em class="mr-5">12</em></a></li>
                            <li><a href=""><i class="fa fa-share-alt"></i></a></li>
                            <li><a><em class="mr-3">03</em></a></li>
                        </ul>
                    </div>
                    <div class="cardbox-comments d-flex align-items-center">
                        <span class="comment-avatar float-left mr-2">
                            <a href=""> 
                                <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                            </a>
                        </span>
                        <div class="search-comment">
                            <input placeholder="Write a comment..." type="text">
                            <button><i class="fas fa-share-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container post mt-4 mb-3 p-0">
                <div class="cardbox text-left shadow-lg bg-white">
                    <div class="cardbox-heading">
                        <div class="dropdown float-right mt-3 mr-3">
                            <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                                <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                            </div>
                        </div>
                        <div class="media m-0">
                            <div class="d-flex m-3">
                                <a href=""><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                            </div>
                            <div class="media-body ml-1 align-self-center">
                                <a href=""><p class="text-dark m-0">...</p></a>
                                <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                                <small><span><i class="icon ion-md-time mt-0"></i> ... 10 hours ago</span></small> <!-- CHANGE date -->
                            </div>
                        </div>
                    </div>
                    <div class="cardbox-item mx-3">
                        <p>Hello</p>
                    </div>

                    <!-- Still hardcoded (needs more views and connection to database) -->
                    <div class="cardbox-base">
                        <ul class="mx-3 mb-1">
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning" 
                                        alt="User"></a></li> 
                            <li><a><span>12 Likes</span></a></li>
                        </ul>
                        <ul class="mx-3 mt-2">
                            <li><a href=""><i class="fa fa-comments"></i></a></li>
                            <li><a><em class="mr-5">12</em></a></li>
                            <li><a href=""><i class="fa fa-share-alt"></i></a></li>
                            <li><a><em class="mr-3">03</em></a></li>
                        </ul>
                    </div>
                    <div class="cardbox-comments d-flex align-items-center">
                        <span class="comment-avatar float-left mr-2">
                            <a href=""> 
                                <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                            </a>
                        </span>
                        <div class="search-comment">
                            <input placeholder="Write a comment..." type="text">
                            <button><i class="fas fa-share-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container post mt-4 mb-3 p-0">
                <div class="cardbox text-left shadow-lg bg-white">
                    <div class="cardbox-heading">
                        <div class="dropdown float-right mt-3 mr-3">
                            <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                            <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                                <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                            </div>
                        </div>
                        <div class="media m-0">
                            <div class="d-flex m-3">
                                <a href=""><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                            </div>
                            <div class="media-body ml-1 align-self-center">
                                <a href=""><p class="text-dark m-0">...</p></a>
                                <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                                <small><span><i class="icon ion-md-time mt-0"></i> ... 10 hours ago</span></small> <!-- CHANGE date -->
                            </div>
                        </div>
                    </div>
                    <div class="cardbox-item mx-3">
                        <p>Hello</p>
                    </div>

                    <!-- Still hardcoded (needs more views and connection to database) -->
                    <div class="cardbox-base">
                        <ul class="mx-3 mb-1">
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                                        alt="User"></a></li> 
                            <li><a href=""><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning" 
                                        alt="User"></a></li> 
                            <li><a><span>12 Likes</span></a></li>
                        </ul>
                        <ul class="mx-3 mt-2">
                            <li><a href=""><i class="fa fa-comments"></i></a></li>
                            <li><a><em class="mr-5">12</em></a></li>
                            <li><a href=""><i class="fa fa-share-alt"></i></a></li>
                            <li><a><em class="mr-3">03</em></a></li>
                        </ul>
                    </div>
                    <div class="cardbox-comments d-flex align-items-center">
                        <span class="comment-avatar float-left mr-2">
                            <a href=""> 
                                <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                            </a>
                        </span>
                        <div class="search-comment">
                            <input placeholder="Write a comment..." type="text">
                            <button><i class="fas fa-share-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <form method="GET">
                <p type="submit"><span>See more </span><i class="fas fa-caret-down"></i></p>
                <br />
            </form>
        </section>
    </div>

    <!-- Side bar -->
    <div class="col-sm-12 col-md-4 col-lg-3 bg-light side-bar side">
        <div class="d-flex justify-content-center">
            <div class="searchbar searchbar-fixed">
                <input class="search_input search_fixed" type="text" name="" placeholder="Search...">
                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
            </div>
        </div>
        <div class="height-45 scroolable">
            <div class="list-group text-left" id="list-tab" role="tablist">

                <a class="friend-list list-group-item list-group-item-action active" id="list-1-list"
                    data-toggle="list" href="#list-1" role="tab" aria-controls="1">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-2-list" data-toggle="list"
                    href="#list-2" role="tab" aria-controls="2">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-3-list" data-toggle="list"
                    href="#list-3" role="tab" aria-controls="3">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-4-list" data-toggle="list"
                    href="#list-4" role="tab" aria-controls="3">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-5-list" data-toggle="list"
                    href="#list-5" role="tab" aria-controls="5">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-6-list" data-toggle="list"
                    href="#list-6" role="tab" aria-controls="6">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-7-list" data-toggle="list"
                    href="#list-7" role="tab" aria-controls="7">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-8-list" data-toggle="list"
                    href="#list-8" role="tab" aria-controls="8">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-9-list" data-toggle="list"
                    href="#list-9" role="tab" aria-controls="9">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-10-list" data-toggle="list"
                    href="#list-10" role="tab" aria-controls="10">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-11-list" data-toggle="list"
                    href="#list-11" role="tab" aria-controls="11">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-12-list" data-toggle="list"
                    href="#list-12" role="tab" aria-controls="12">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>

                <p class="text-center list-group-item p-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
            </div>
        </div>
        <div class="border-left height-45">
            <div class="py-3 px-3 border rounded text-left tab-content chat-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-1" role="tabpanel" aria-labelledby="list-1-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-2" role="tabpanel" aria-labelledby="list-2-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-3" role="tabpanel" aria-labelledby="list-3-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-4" role="tabpanel" aria-labelledby="list-4-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">João Miguel</a>
                </div>
                <div class="tab-pane fade" id="list-5" role="tabpanel" aria-labelledby="list-5-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-6" role="tabpanel" aria-labelledby="list-6-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-7" role="tabpanel" aria-labelledby="list-7-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-8" role="tabpanel" aria-labelledby="list-8-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">João Miguel</a>
                </div>
                <div class="tab-pane fade" id="list-9" role="tabpanel" aria-labelledby="list-9-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-10" role="tabpanel" aria-labelledby="list-19-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-11" role="tabpanel" aria-labelledby="list-11-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-12" role="tabpanel" aria-labelledby="list-12-list">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="{{ url('/profile') }}">João Miguel</a>
                </div>
            </div>
            <div class="border-top border-left w-100 bottom-contained send-message p-0 d-flex align-items-center">
                <input type="text" class="m-2 border w-75 no-outline" id="message-box" placeholder="Write a message here..."
                    required>
                <button type="submit" class="btn btn-primary m-1 float-right" id="send-button">&#9993;</button>
            </div>
        </div>
    </div>
</div>
@endsection