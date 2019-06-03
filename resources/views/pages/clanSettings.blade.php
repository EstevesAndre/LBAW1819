@extends('layouts.app')

@section('content')

<br />
    <br />
    <div class="container justify-content-center fullscreen-3-4 my-5">
        <h1>Clan Settings - {{$clan->name}}  - {{$clan->members()->count()}} 
            <button type="button" class="border-0 btn btn-default btn-circle" data-toggle="modal" data-target="#clansettings_helpModal">
                    <i class="fas fa-question-circle"></i>
            </button>
        </h1>
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
                        <form class="form-inline p-2"  method="post" action="/api/update_clan/{{$clan->id}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="shadow-lg w-100">
                                <div class="card card-body pt-3">
                                    <div>
                                        <h4>Name</h4>
                                        <div class="py-2 float-left">Current: {{$clan->name}}</div>
                                        <button class="bg-dark btn float-right" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            <span class="text-white">Edit <i class="fas fa-pencil-alt"></i></span>
                                        </button>
                                    </div>
                                    <div class="collapse pt-2" id="collapseExample">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">New name:
                                                    <input class="form-control ml-2" type="text" name="name" id="exampleFormControlInput1" placeholder="">
                                                </label>
                                            </div>
                                    </div>
                                </div>
                                <div class="card card-body">
                                    <div>
                                        <h4>Clan Bio</h4>
                                        <div class="py-2 float-left">Current: {{$clan->description}}</div>
                                        <button class="bg-dark btn float-right" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                                            <span class="text-white">Edit <i class="fas fa-pencil-alt"></i></span>
                                        </button>
                                    </div>
                                    <div class="collapse px-0 pt-3" id="collapseExample2">
                                            <div class="form-group w-100">
                                                <textarea class="form-control w-100" name="description" rows="4" type="text" placeholder="write here..."></textarea>
                                            </div>
                                    </div>
                                </div>
                                <div class="card card-body">
                                    <div>
                                        <h4>Change Clan Image</h4>
                                        <div class="py-2 float-left">Insert a new image</div>
                                        <button class="bg-dark btn float-right" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3">
                                            <span class="text-white">Edit <i class="fas fa-pencil-alt"></i></span>
                                        </button>
                                    </div>
                                    <div class="collapse" id="collapseExample3">
                                        <div class="form-group w-100">
                                            <p><p>
                                            <label for="clanImage">
                                                <input type="file" name="clan_img" accept="image/png, image/jpeg" class="form-control-file input-file mt-2" id="clanImage">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="text-center my-4">
                                <button type="submit" class="btn btn-secondary">Save Changes</button>
                            </div>
                        </form>
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
                                        <div class="form-check">
                                            <input class="form-check-input" name="motive" type="radio" value="Inappropriate behaviour" id="defaultCheck1">Inappropriate behaviour
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="motive" type="radio" value="Abusive content" id="defaultCheck2">Abusive content
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="motive" type="radio" value="Racism" id="defaultCheck3">Racism
                                        </div>
                                        
                                        <br>
                                        <p>Ban Duration</p>
                                        <select class="form-control bg-dark .text-light w-75 mt-3" id="exampleFormControlSelect1">
                                            <option value="0" selected disabled>Ban Duration</option>
                                            <option value="7">7 days</option>
                                            <option value="14">2 weeks</option>
                                            <option value="31">1 month</option>
                                            <option value="93">3 months</option>
                                            <option value="186">6 months</option>
                                            <option value="365">1 year</option>
                                            <option value="-1">Forever</option>
                                        </select>
                                        <p class="error-msg"></p>
                                        <button type="button" id="" data-dismiss="modal" class="ban_modal btn btn-danger mt-3 float-right">Ban!</button>
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

                        <h3>Active Members</h3>
                        <ul class="active pl-0 shadow-lg users-list">
                                @each('partials.clanSettingsMembers', $members, 'member')
                            <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                        </ul>
                        
                        <h3>Banned Members</h3>
                        <ul class="banned pl-0 shadow-lg users-list">
                                @each('partials.clanSettingsBlocked', $blocked, 'blocked')
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
    <!-- Modal -->
<div class="modal fade" id="clansettings_helpModal" tabindex="-1" role="dialog" aria-labelledby="clansettings_helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clansettings_helpModalLabel">Clan Settings Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This is the clan settings page.
            </div>
        </div>
    </div>
</div>