@extends('layouts.app')

@section('pageTitle', 'Administation')

@section('content')
<br>
<br>
<div class="container justify-content-center my-5">
    <h1 class="text-center"><b>Administrator's Page</b>
        <button type="button" class="border-0 btn btn-default rounded-circle" data-toggle="modal" data-target="#clan_helpModal">
            <i class="fas fa-question-circle"></i>
        </button>
    </h1>
    <div class="admin-content my-4">
        <ul class="nav nav-pills nav-fill pb-3 border-bottom">
            <li class="nav-item mx-2">
                <a class="nav-link bg-secondary text-white text-center my-2 active" 
                id="v-pills-manage-users-tab" data-toggle="pill" href="#v-pills-manage-users" role="tab" 
                aria-controls="v-pills-manage-users" aria-selected="false">Manage Users</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link bg-secondary text-white text-center my-2" 
                id="v-pills-manage-clans-tab" data-toggle="pill" href="#v-pills-manage-clans" role="tab" 
                aria-controls="v-pills-manage-clans" aria-selected="false">Manage Clans</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link bg-secondary text-white text-center my-2" 
                id="v-pills-administrators-tab" data-toggle="pill" href="#v-pills-administrators" role="tab" 
                aria-controls="v-pills-administrators" aria-selected="false">Manage Administrators</a>
            </li>
        </ul>
        <div class="clan-page-info">
            <div class="tab-content" id="v-pills-tabContent">
                {{-- manage-users --}}
                <div class="mt-3 tab-pane fade show active" id="v-pills-manage-users" role="tabpanel" aria-labelledby="v-pills-manage-users-tab">            
                    {{-- <h4 class="text-center">Manage Users</h4> --}}
                    
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
                    
                    <div class="mt-4 tab-content" id="users-content">
                        <div class="text-left tab-pane fade border-0 active show" id="active" role="tabpanel" aria-labelledby="active-tab">
                            @if($activeUsers->count() > 0)    
                                <div class="d-flex justify-content-center mb-3 mr-3">
                                    <div class="searchbar">
                                        <input class="search_input search_input_fixed" onkeyup="activeUsersSearch()" type="text" name="" placeholder="Search...">
                                        <div class="search_icon"><i class="fas fa-search"></i></div>
                                    </div>
                                </div>
                                
                                <ul class="users-active pl-0 shadow-lg users-list">
                                    @each('partials.adminActiveUserList', $activeUsers->take(7), 'user')
                                    @if($activeUsers->count() > 7)
                                        <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
                                    @endif
                                </ul>
                            @else
                                <h5 class="my-5 text-center">There are no active users</h5>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="banned" role="tabpanel" aria-labelledby="banned-tab">
                            @if($bannedUsers->count() > 0)
                                <div class="d-flex justify-content-center mb-3 mr-3">
                                    <div class="searchbar">
                                        <input class="search_input search_input_fixed" onkeyup="bannedUsersSearch()" type="text" name="" placeholder="Search...">
                                        <div class="search_icon"><i class="fas fa-search"></i></div>
                                    </div>
                                </div>

                                <ul class="users-banned pl-0 shadow-lg users-list">
                                    @each('partials.adminBannedUserList', $bannedUsers, 'user')
                                    @if($bannedUsers->count() > 7)
                                        <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
                                    @endif
                                </ul>
                            @else
                                <h5 class="my-5 text-center">There are no banned users</h5>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- manage-clans --}}
                <div class="mt-3 tab-pane fade" id="v-pills-manage-clans" role="tabpanel" aria-labelledby="v-pills-manage-clans-tab">
                    {{-- <h4 class="text-center">Manage Clans</h4> --}}
                
                    <ul class="justify-content-center mt-3 nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="tab-title bg-secondary text-white nav-link active" id="active-clans-tab" data-toggle="tab" href="#active-clans" role="tab"
                                aria-controls="active" aria-selected="true">Active Clans</a>
                        </li>
                        <li class="nav-item ml-4">
                            <a class="tab-title bg-secondary text-white nav-link" id="banned-clans-tab" data-toggle="tab" href="#banned-clans" role="tab"
                                aria-controls="banned" aria-selected="false">Banned Clans</a>
                        </li>
                    </ul>
                    <div class="mt-4 tab-content" id="clans-content">
                        <div class="text-left tab-pane fade border-0 active show" id="active-clans" role="tabpanel" aria-labelledby="active-clans-tab">
                            @if($activeClans->count() > 0)
                                <div class="d-flex justify-content-center mb-3 mr-3">
                                    <div class="searchbar">
                                        <input class="search_input search_input_fixed" onkeyup="activeClansSearch()" type="text" name="" placeholder="Search...">
                                        <div class="search_icon"><i class="fas fa-search"></i></div>
                                    </div>
                                </div>
                                <ul class="clans-active shadow-lg pl-2 users-list">
                                    @each('partials.adminActiveClanList', $activeClans, 'clan')
                                </ul>
                            @else
                                <h5 class="my-5 text-center">There are no active clans</h5>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="banned-clans" role="tabpanel" aria-labelledby="banned-clans-tab">
                            <div class="d-flex justify-content-center mb-3 mr-3">
                                <div class="searchbar">
                                    <input class="search_input search_input_fixed" onkeyup="bannedClansSearch()" type="text" name="" placeholder="Search...">
                                    <div class="search_icon"><i class="fas fa-search"></i></div>
                                </div>
                            </div>
                            <ul class="clans-banned pl-2 shadow-lg users-list">
                                @each('partials.adminBannedClanList', $bannedClans, 'clan')
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- manage-admins --}}
                <div class="mt-3 tab-pane fade" id="v-pills-administrators" role="tabpanel" aria-labelledby="v-pills-administrators-tab">
                    {{-- <h4 class="text-center">Manage Administrators</h4> --}}
                    
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary mb-4" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-user-plus"></i> Add Administrator
                        </button>
                    </div>
                    <div class="d-flex justify-content-center mb-3 mr-3" id="admins-content">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" onkeyup="activeAdminsSearch()" type="text" name="" placeholder="Search...">
                            <div class="search_icon"><i class="fas fa-search"></i></div>
                        </div>
                    </div>
                    <ul class="admins-active pl-2 shadow-lg users-list">
                        @each('partials.adminActiveAdminsList', $admins, 'user')
                    </ul>
                </div>
                {{-- home --}}
                <div class="text-center mt-5">
                    <a class="no-hover index-nav" href="{{ url('home') }}">
                        <button type="button" class="btn btn-secondary"><i class="fas fa-save"></i> Home</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clan Help Modal -->
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

<!-- Users Ban Modal -->
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
                <div class="form-check">
                    <input class="form-check-input" name="motive" type="radio" value="Inappropriate behaviour" id="defaultCheck1">Inappropriate behaviour
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="motive" type="radio" value="Abusive content" id="defaultCheck2">Abusive content
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="motive" type="radio" value="Racism" id="defaultCheck3">Racism
                </div>
                <br />
                <p>Ban Duration</p>
                <select class="form-control w-75 mt-3" id="exampleFormControlSelect1">
                    <option value="0" selected disabled>Duration</option>
                    <option value="7">7 days</option>
                    <option value="14">2 weeks</option>
                    <option value="31">1 month</option>
                    <option value="93">3 months</option>
                    <option value="186">6 months</option>
                    <option value="365">1 year</option>
                    <option value="-1">Forever</option>
                </select>
                <p class="text-center mt-2 mb-0 msg-response">&nbsp</p>
                <button type="button" data-dismiss="modal" class="btn btn-secondary mt-2 mx-2 float-right">Close!</button>
                <button type="button" class="btn-ban-modal btn btn-danger mt-2 float-right"><i class="fas fa-user-times"></i> Ban!</button>
            </div>
        </div>
    </div>
</div>
<!-- Users Unban Modal -->
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
                <p>His/her ban ends <small class="end-date"></small></p>
                <div class="float-right">
                    <button type="button" id="" data-dismiss="modal" class="btn-unban-modal btn btn-success">Yes</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clans Ban Modal -->
<div class="modal fade" id="clanBanModal" tabindex="-1" role="dialog" aria-labelledby="clanBanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clanBanModalLabel">Ban Clan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want to ban this Clan?</p>
                <div class="form-check">
                    <input class="form-check-input" name="motive" type="radio" value="Inappropriate behaviour" id="clancheck1">Inappropriate behaviour
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="motive" type="radio" value="Abusive content" id="clancheck2">Abusive content
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="motive" type="radio" value="Racism" id="clancheck3">Racism
                </div>
                <br />
                <p>Ban Duration</p>
                <select class="form-control w-75 mt-3" id="selectionBanClan">
                    <option value="0" selected disabled>Duration</option>
                    <option value="7">7 days</option>
                    <option value="14">2 weeks</option>
                    <option value="31">1 month</option>
                    <option value="93">3 months</option>
                    <option value="186">6 months</option>
                    <option value="365">1 year</option>
                    <option value="-1">Forever</option>
                </select>
                <p class="text-center mt-2 mb-0 msg-response">&nbsp</p>
                <button type="button" data-dismiss="modal" class="btn btn-secondary mt-2 mx-2 float-right">Close!</button>
                <button type="button" class="btn-ban-clan-modal btn btn-danger mt-2 float-right"><i class="fas fa-user-times"></i> Ban!</button>
            </div>
        </div>
    </div>
</div>
<!-- Clans Unban Modal -->
<div class="modal fade" id="clanUnbanModal" tabindex="-1" role="dialog" aria-labelledby="clanUnbanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clanUnbanModalLabel">Unban Clan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want to unban this clan?</p>
                <p>This ban ends <small class="end-date"></small></p>
                <div class="float-right">
                    <button type="button" id="" data-dismiss="modal" class="btn-unban-clan-modal btn btn-success">Yes</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin Remove Permissions Modal -->
<div class="modal fade" id="removePermModal" tabindex="-1" role="dialog" aria-labelledby="removePermModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removePermModalLabel">Remove Permissions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want to remove admin permissions?</p>
                <div class="float-right">
                    <button type="button" id="" data-dismiss="modal" class="btn-rm-permissions-modal btn btn-success">Yes</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add permissions Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Administrator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center mb-3 mr-3">
                    <div class="searchbar">
                        <input class="search_input search_input_fixed" onkeyup="potentialAdminsSearch()" type="text" name="" placeholder="Search...">
                        <div class="search_icon"><i class="fas fa-search"></i></div>
                    </div>
                </div>
                <ul class="not-admin-users pl-0 shadow-lg users-list">
                    @each('partials.userCheckbox', $potentialAdmins, 'user')
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="add_permissions btn btn-success"><i class="fas fa-user-plus"></i> Add</button>
            </div>
        </div>
    </div>
</div>

@endsection

