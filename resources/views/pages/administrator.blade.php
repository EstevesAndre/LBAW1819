@extends('layouts.app')

@section('content')
<br>
<br>
<div class="container justify-content-center my-5">
    <h1 class="text-center"><b>Administrator's Page</b>
        <button type="button" class="border-0 btn btn-default btn-circle" data-toggle="modal" data-target="#clan_helpModal">
            <i class="fas fa-question-circle"></i>
        </button>
    </h1>
    <div class="row admin-content my-4">
        <div class="col-12 col-sm-12 col-md-4 bt-border">
            <div class="nav flex-column nav-pills mb-3" id="v-pills-tab" role="tablist">
                <a class="nav-link bg-secondary text-white text-center my-2 active" 
                    id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" 
                        aria-controls="v-pills-reports" aria-selected="true">Reports</a>
                <a class="nav-link bg-secondary text-white text-center my-2" 
                    id="v-pills-manage-users-tab" data-toggle="pill" href="#v-pills-manage-users" role="tab" 
                        aria-controls="v-pills-manage-users" aria-selected="false">Manage Users</a>
                <a class="nav-link bg-secondary text-white text-center my-2" 
                    id="v-pills-manage-clans-tab" data-toggle="pill" href="#v-pills-manage-clans" role="tab" 
                        aria-controls="v-pills-manage-clans" aria-selected="false">Manage Clans</a>
                <a class="nav-link bg-secondary text-white text-center my-2" 
                    id="v-pills-administrators-tab" data-toggle="pill" href="#v-pills-administrators" role="tab" 
                        aria-controls="v-pills-administrators" aria-selected="false">Manage Administrators</a>
            </div>
        </div>
        <div class="clan-page-info col-12 col-sm-12 col-md-8">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
                    <h4 class="text-center">Manage Users</h4>
                    
                    <ul class="justify-content-center mt-3 nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="tab-title bg-secondary text-white nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab"
                                aria-controls="active" aria-selected="true">Active Users</a>
                        </li>
                        <li class="nav-item ml-4">
                            <a class="tab-title bg-secondary text-white nav-link" id="banned-tab" data-toggle="tab" href="#banned" role="tab"
                                aria-controls="banned" aria-selected="false">Banned Users</a>
                        </li>
                    </ul>
                    
                    <div class="mt-4 tab-content" id="leaderboard-content">
                        <div class="text-left tab-pane fade border-0 active show" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="d-flex justify-content-center mb-3 mr-3">
                                <div class="searchbar">
                                    <input class="search_input search_input_fixed" onkeyup="fff()" type="text" name="" placeholder="Search...">
                                    <div class="search_icon"><i class="fas fa-search"></i></div>
                                </div>
                            </div>
                            <ul class="pl-0 shadow-lg users-list">
                                {{-- @each('partials.chatFriend', $friends->slice(1,10), 'user') --}}
                                
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="banned" role="tabpanel" aria-labelledby="banned-tab">
                        
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 mt-4">
                            <a class="no-hover index-nav" href="{{ url('home') }}">
                                <button type="button" class="btn btn-secondary"><i class="fas fa-undo"></i> Back without saving</button>
                            </a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 mt-4 ali-right">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#saveChangesModal">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="v-pills-manage-users" role="tabpanel" aria-labelledby="v-pills-manage-users-tab">
                </div>
                <div class="tab-pane fade" id="v-pills-manage-clans" role="tabpanel" aria-labelledby="v-pills-manage-clans-tab">
                </div>
                <div class="tab-pane fade" id="v-pills-administrators" role="tabpanel" aria-labelledby="v-pills-administrators-tab">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="clan_helpModal" tabindex="-1" role="dialog" aria-labelledby="clan_helpModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clan_helpModalLabel">Clan Help</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                This is the administation page.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ban Modal -->
<div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="banModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="banModalLabel">Ban User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want to ban this user?</p>
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
<!-- Unban Modal -->
<div class="modal fade" id="unbanModal" tabindex="-1" role="dialog" aria-labelledby="unbanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unbanModalLabel">Unban User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want to unban this user?</p>
                <p><small>10 Days 5 hours 34 minutes 20 seconds</small> to unban</p>
                <div class="float-right">
                    <button type="button" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Save Changes Modal -->
<div class="modal fade" id="saveChangesModal" tabindex="-1" role="dialog" aria-labelledby="saveChangesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saveChangesModalLabel">Save Changes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want to save?</p>
                <div class="float-right">
                    <button type="button" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

