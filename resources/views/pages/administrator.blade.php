@extends('layouts.app')

@section('content')
<br>
<br>
<div class="container mt-5">
        <h1 class="text-center"><b>Administrator's Page</b></h1>
        <div class="row admin-content py-3 px-3">
            <div class="col-md-3 rt-border mb-3">
                <ul class="nav navbar-nav side-nav fixed admin-sidebar">
                    <li class="my-2">
                        <a href="manageUsers.html"><i class="fas fa-user"></i> Manage Users</a>
                    </li>
                    <li class="my-2">
                        <a href="manageClans.html"><i class="fas fa-users"></i> Manage Clans</a>
                    </li>
                    <li class="my-2">
                        <a href="manageAdministrators.html"><i class="fas fa-user-shield"></i> Manage Administrators</a>
                    </li>
                </ul>
            </div>

            <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportModalLabel">Ignore report</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure that you want to ignore this report?</p>
                            <div class="float-right">
                                <button type="button" class="btn btn-success">Yes</button>
                                <button type="button" class="btn btn-danger">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="float-right col-md-9">
                <div class="float-right mt-4 pr-2 dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter By
                    </button>
                    <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">User</a>
                        <a class="dropdown-item" href="#">Clan</a>
                    </div>
                </div>
                <div class="text-left mt-4">
                    <h3 class="mb-4">Newest Reports</h3>
                    <ul class="report-list pl-0">
                        <li class="shadow-sm border">
                            <div class="py-2 px-3 float-right">
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#reportModal">
                                    <i class="fas fa-times color-black standard-text"></i>
                                </button>
                            </div>
                            <p class="px-3 mx-2 mt-4">André Esteves reported Francisco Filipe</p>
                            <div class="row tags text-center pb-4 px-5">
                                <div class="col-12 col-sm-5 report-tag">User</div>
                                <div class="col-12 col-sm-5 report-tag">Abusive content</div>
                            </div>
                        </li>
                        <li class="shadow-sm border">
                            <div class="py-2 px-3 float-right">
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#reportModal">
                                    <i class="fas fa-times color-black standard-text"></i>
                                </button>
                            </div>
                            <p class="px-3 mx-2 mt-4">André Esteves reported Francisco Filipe</p>
                            <div class="row tags text-center pb-4 px-5">
                                <div class="col-12 col-sm-5 report-tag">User</div>
                                <div class="col-12 col-sm-5 report-tag">Abusive content</div>
                            </div>
                        </li>
                        <li class="shadow-sm border">
                            <div class="py-2 px-3 float-right">
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#reportModal">
                                    <i class="fas fa-times color-black standard-text"></i>
                                </button>
                            </div>
                            <p class="px-3 mx-2 mt-4">André Esteves reported PT-Pokemons</p>
                            <div class="row tags text-center pb-4 px-5">
                                <div class="col-12 col-sm-5 report-tag">Clan</div>
                            </div>
                        </li>
                        <li class="shadow-sm border">
                            <div class="py-2 px-3 float-right">
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#reportModal">
                                    <i class="fas fa-times color-black standard-text"></i>
                                </button>
                            </div>
                            <p class="px-3 mx-2 mt-4">João banned Luís Silva</p>
                            <div class="row tags text-center pb-4 px-5">
                                <div class="col-12 col-sm-5 report-tag">User</div>
                                <div class="col-12 col-sm-5 report-tag">Racism</div>
                                <div class="col-12 col-sm-5 report-tag">Abusive content</div>
                            </div>
                        </li>
                        <li class="shadow-sm border">
                            <div class="py-2 px-3 float-right">
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#reportModal">
                                    <i class="fas fa-times color-black standard-text"></i>
                                </button>
                            </div>
                            <p class="px-3 mx-2 mt-4">Diogo banned Bruno's Clan</p>
                            <div class="row tags text-center pb-4 px-5">
                                <div class="col-12 col-sm-5 report-tag">Clan</div>
                                <div class="col-12 col-sm-5 report-tag">Inappropriate behaviour</div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
</div>
@endsection