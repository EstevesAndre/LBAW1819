@extends('layouts.app')

@section('content')

<br />
    <br />
    <div class="container justify-content-center fullscreen-3-4 my-5">
        <h1>Clan Settings</h1>
        <div class="row my-4">
            <div class="col-12 col-sm-12 col-md-4 bt-border">
                <div class="nav flex-column nav-pills mb-3" id="v-pills-tab" role="tablist">
                    <a class="nav-link bg-secondary text-white text-center my-2 active" id="v-pills-geral-tab" data-toggle="pill" href="#v-pills-geral" role="tab" aria-controls="v-pills-geral" aria-selected="true">General</a>
                    <a class="nav-link bg-secondary text-white text-center my-2" id="v-pills-activity-tab" data-toggle="pill" href="#v-pills-activity" role="tab" aria-controls="v-pills-activity" aria-selected="false">Activity Regist</a>
                    <a class="nav-link bg-secondary text-white text-center my-2" id="v-pills-manage-users-tab" data-toggle="pill" href="#v-pills-manage-users" role="tab" aria-controls="v-pills-manage-users" aria-selected="false">Manage Users</a>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-8">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-geral" role="tabpanel" aria-labelledby="v-pills-geral-tab">
                        <!-- Change Name ; Change Brief ; Change Clan Image -->
                        <div class="shadow-lg">
                            <div class="card card-body mt-3">
                                <div>
                                    <h4>Name</h4>
                                    <div class="p-2 float-left">{{$clan->name}}</div>
                                    <button class="bg-dark btn float-right" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        <span class="text-white">Edit <i class="fas fa-pencil-alt"></i></span>
                                    </button>
                                </div>
                                <div class="collapse" id="collapseExample">
                                    <form class="form-inline px-4 py-2">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New Name</label>
                                            <input class="form-control ml-2" type="text" id="exampleFormControlInput1" placeholder="">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card card-body">
                                <div>
                                    <h4>Clan Bio</h4>
                                    <div class="p-2 float-left">{{$clan->description}}</div>
                                    <button class="bg-dark btn float-right" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                                        <span class="text-white">Edit <i class="fas fa-pencil-alt"></i></span>
                                    </button>
                                </div>
                                <div class="collapse" id="collapseExample2">
                                    <form class="form-inline px-4 py-2">
                                        <div class="form-group w-100">
                                            <textarea class="form-control ml-2 w-100" rows="4" type="text" placeholder="write here..."></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card card-body">
                                <div>
                                    <div class="p-2 float-left">Change Clan Image</div>
                                    <button class="bg-dark btn float-right" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3">
                                        <span class="text-white">Edit <i class="fas fa-pencil-alt"></i></span>
                                    </button>
                                </div>
                                <div class="collapse" id="collapseExample3">
                                    <form class="form-inline px-4 py-2">
                                        <div class="form-group w-100">
                                            <label for="clanImage">Insert a new clan Image</label>
                                            <input type="file" class="form-control-file input-file mt-2" id="clanImage">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="text-center my-4">
                            <button type="submit" class="btn btn-secondary">Save Changes</button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-activity" role="tabpanel" aria-labelledby="v-pills-activity-tab">
                        <!-- User; Post Date ; Number Likes ; Number Comments ; Number of sharings -->
                        <ul class="pl-0 shadow-lg users-list">
                            <li class="card card-body activity mt-3">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-12 col-md-5">
                                        <div class="row">
                                            <div class="col-7 col-sm-8 col-md-12"><a href="../pages/profile.html" class="no-hover">Francisco Filipe</a></div>
                                            <div class="col-5 col-sm-4 col-md-12"><span><small>29/03/2019</small></span></div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 pr-0 text-center">
                                        <small><span>12 Likes</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-3 p-0 text-center">
                                        <small><span>6 Comments</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 p-0 text-center">
                                        <small><span>5 Shares</span></small>
                                    </div>
                                </div>
                            </li>
                            <li class="card card-body activity">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-12 col-md-5">
                                        <div class="row">
                                            <div class="col-7 col-sm-8 col-md-12"><a href="../pages/profile.html" class="no-hover">Filipe Pinto</a></div>
                                            <div class="col-5 col-sm-4 col-md-12"><span><small>19/02/2019</small></span></div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 pr-0 text-center">
                                        <small><span>132 Likes</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-3 p-0 text-center">
                                        <small><span>62 Comments</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 p-0 text-center">
                                        <small><span>15 Shares</span></small>
                                    </div>
                                </div>
                            </li>
                            <li class="card card-body activity">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-12 col-md-5">
                                        <div class="row">
                                            <div class="col-7 col-sm-8 col-md-12"><a href="../pages/profile.html" class="no-hover">Antero Santos</a></div>
                                            <div class="col-5 col-sm-4 col-md-12"><span><small>15/02/2019</small></span></div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 pr-0 text-center">
                                        <small><span>1552 Likes</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-3 p-0 text-center">
                                        <small><span>236 Comments</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 p-0 text-center">
                                        <small><span>125 Shares</span></small>
                                    </div>
                                </div>
                            </li>
                            <li class="card card-body activity">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-12 col-md-5">
                                        <div class="row">
                                            <div class="col-7 col-sm-8 col-md-12"><a href="../pages/profile.html" class="no-hover">Luís Silva</a></div>
                                            <div class="col-5 col-sm-4 col-md-12"><span><small>1/01/2019</small></span></div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 pr-0 text-center">
                                        <small><span>450 Likes</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-3 p-0 text-center">
                                        <small><span>123 Comments</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 p-0 text-center">
                                        <small><span>23 Shares</span></small>
                                    </div>
                                </div>
                            </li>
                            <li class="card card-body activity">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-12 col-md-5">
                                        <div class="row">
                                            <div class="col-7 col-sm-8 col-md-12"><a href="../pages/profile.html" class="no-hover">Joana Francisca</a></div>
                                            <div class="col-5 col-sm-4 col-md-12"><span><small>23/12/2018</small></span></div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 pr-0 text-center">
                                        <small><span>49 Likes</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-3 p-0 text-center">
                                        <small><span>36 Comments</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 p-0 text-center">
                                        <small><span>15 Shares</span></small>
                                    </div>
                                </div>
                            </li>
                            <li class="card card-body activity">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-12 col-md-5">
                                        <div class="row">
                                            <div class="col-7 col-sm-8 col-md-12"><a href="../pages/profile.html" class="no-hover">Maja Krsteva</a></div>
                                            <div class="col-5 col-sm-4 col-md-12"><span><small>30/07/2018</small></span></div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 pr-0 text-center">
                                        <small><span>1413 Likes</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-3 p-0 text-center">
                                        <small><span>468 Comments</span></small>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 p-0 text-center">
                                        <small><span>185 Shares</span></small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-manage-users" role="tabpanel" aria-labelledby="v-pills-manage-users-tab">

                        <div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="banModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="banModalLabel">Ban Clan Member</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure that you want to ban this Clan Member?</p>
                                        <textarea class="form-control text-left my-3 w-100" rows="4" placeholder="Write something about the ban..."></textarea>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                Innapropriate behaviour
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                            <label class="form-check-label" for="defaultCheck2">
                                                Abusive content
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                                            <label class="form-check-label" for="defaultCheck3">
                                                Racism
                                            </label>
                                        </div>
                                        <button class="btn btn-secondary w-75 mt-3 dropdown-toggle" type="button" id="dropdownBanButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ban Duration
                                        </button>
                                        <div class="dropdown-menu mr-4 w-50 text-center" aria-labelledby="dropdownBanButton">
                                            <a class="dropdown-item">7 days</a>
                                            <a class="dropdown-item">2 weeks</a>
                                            <a class="dropdown-item">1 month</a>
                                            <a class="dropdown-item">3 months</a>
                                            <a class="dropdown-item">6 months</a>
                                            <a class="dropdown-item">1 year</a>
                                            <a class="dropdown-item">Forever</a>
                                        </div>
                                        <button type="button" class="btn btn-danger mt-3 float-right">Ban!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="removeClanModal" tabindex="-1" role="dialog" aria-labelledby="removeClanModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="removeClanModalLabel">Delete Clan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure that you want to remove your Clan?</p>
                                        <div class="float-right">
                                            <button type="button" class="btn btn-success">Yes</button>
                                            <button type="button" class="btn btn-danger">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="addMembersModal" tabindex="-1" role="dialog" aria-labelledby="addMembersModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addMembersModalLabel">Invite new friends</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center mb-3 mr-3">
                                            <div class="searchbar">
                                                <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                                                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                                            </div>
                                        </div>
                                        <ul class="pl-0 users-list">
                                            <li class="p-2 ml-3">
                                                <div class="d-flex align-items-center row">
                                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                                            src="../assets/logo.png" alt="User">
                                                    </div>
                                                    <div class="col-7 col-sm-6 col-md-7 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Sara Santos</a></div>
                                                    <div class="col-2 col-sm-3 col-md-3 px-0 text-right">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="p-2 ml-3">
                                                <div class="d-flex align-items-center row">
                                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                                            src="../assets/logo.png" alt="User">
                                                    </div>
                                                    <div class="col-7 col-sm-6 col-md-7 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Diana Soares</a></div>
                                                    <div class="col-2 col-sm-3 col-md-3 px-0 text-right">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="p-2 ml-3">
                                                <div class="d-flex align-items-center row">
                                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                                            src="../assets/logo.png" alt="User">
                                                    </div>
                                                    <div class="col-7 col-sm-6 col-md-7 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Cláudia Pinto</a></div>
                                                    <div class="col-2 col-sm-3 col-md-3 px-0 text-right">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="p-2 ml-3">
                                                <div class="d-flex align-items-center row">
                                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                                            src="../assets/logo.png" alt="User">
                                                    </div>
                                                    <div class="col-7 col-sm-6 col-md-7 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Cristiano Amorim</a></div>
                                                    <div class="col-2 col-sm-3 col-md-3 px-0 text-right">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="p-2 ml-3">
                                                <div class="d-flex align-items-center row">
                                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                                            src="../assets/logo.png" alt="User">
                                                    </div>
                                                    <div class="col-7 col-sm-6 col-md-7 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">António Teixeira</a></div>
                                                    <div class="col-2 col-sm-3 col-md-3 px-0 text-right">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success"><i class="fas fa-user-plus"></i> Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center my-3 mr-3">
                            <div class="searchbar">
                                <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                        <ul class="pl-0 shadow-lg users-list">
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Juan Maruto</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Daniel Nazário</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Bruno Alves</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Daniel Cardoso</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Catarina Nazário</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Joana Pinto</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Rui Rio</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Mário Gil</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Joana Madureira</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="Clan">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Juan Maruto</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#banModal">
                                            <i class="fas fa-user-times"></i> Ban<span> Member</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                        </ul>
        
                        <div class="mt-4">
                            <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                data-target="#addMembersModal">
                                <i class="fas fa-envelope"></i> Invite User
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#removeClanModal">
                                <i class="fas fa-ban"></i> Delete Clan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>