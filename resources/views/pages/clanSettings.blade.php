@extends('layouts.app')

@section('content')

<br />
    <br />
<div class="settings container justify-content-center fullscreen-3-4 my-5" data-id="{{$clan->id}}">
    <h1 class="text-center">Clan Settings - {{$clan->name}}  - {{$clan->members()->count()}} 
        <button type="button" class="border-0 btn btn-default rounded-circle" data-toggle="modal" data-target="#clansettings_helpModal">
            <i class="fas fa-question-circle"></i>
        </button>
    </h1>
    <div class="my-4">
        <ul class="nav nav-pills nav-fill pb-3 border-bottom">
            <li class="nav-item mx-2">
                <a class="nav-link bg-secondary text-white text-center my-2 active" id="v-pills-geral-tab" data-toggle="pill" href="#v-pills-geral" role="tab" aria-controls="v-pills-geral" aria-selected="true">General</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link bg-secondary text-white text-center my-2" id="v-pills-manage-users-tab" data-toggle="pill" href="#v-pills-manage-users" role="tab" aria-controls="v-pills-manage-users" aria-selected="false">Manage Users</a>
            </li>
        </ul>
        <div class="mt-3 tab-content" id="v-pills-tabContent">
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
                    <div class="text-center my-4 w-100">
                        <button type="submit" class="btn btn-secondary">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="v-pills-manage-users" role="tabpanel" aria-labelledby="v-pills-manage-users-tab">
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
                        @if($members->count() > 0)    
                            <div class="d-flex justify-content-center mb-3 mr-3">
                                <div class="searchbar">
                                    <input class="search_input search_input_fixed" onkeyup="fff()" type="text" name="" placeholder="Search...">
                                    <div class="search_icon"><i class="fas fa-search"></i></div>
                                </div>
                            </div>
                            
                            <ul class="active pl-2 shadow-lg users-list">
                                @each('partials.clanSettingsMembers', $members->take(7), 'member')
                                @if($members->count() > 7)
                                    <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
                                @endif
                            </ul>
                        @else
                            <h5 class="my-5 text-center">There are no active users</h5>
                        @endif
                        <div class="mt-4">
                            <button type="button invite" class="btn btn-success float-right" data-toggle="modal"
                                data-target="#addMembersModal">
                                <i class="fas fa-envelope"></i> Invite Users
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#removeClanModal">
                                <i class="fas fa-ban"></i> Delete Clan
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="banned" role="tabpanel" aria-labelledby="banned-tab">
                        @if($blocked->count() > 0)
                            <div class="d-flex justify-content-center mb-3 mr-3">
                                <div class="searchbar">
                                    <input class="search_input search_input_fixed" onkeyup="fff()" type="text" name="" placeholder="Search...">
                                    <div class="search_icon"><i class="fas fa-search"></i></div>
                                </div>
                            </div>

                            <ul class="banned pl-0 shadow-lg users-list">
                                @each('partials.clanSettingsBlocked', $blocked, 'blocked')
                                @if($blocked->count() > 7)
                                    <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
                                @endif
                            </ul>
                        @else
                            <h5 class="my-5 text-center">There are no banned users</h5>
                        @endif
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
                <p class="ml-2 mt-2 error-msg"></p>
                <button type="button" data-dismiss="modal" class="btn btn-secondary mt-3 mx-2 float-right">Close!</button>
                <button type="button" id="" class="ban_modal btn btn-danger mt-3 float-right">Ban!</button>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade" id="removeClanModal" tabindex="-1" role="dialog" aria-labelledby="removeClanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeClanModalLabel">Delete Clan</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want to remove your Clan?</p>
                <div class="float-right">
                    <button type="button" data-dismiss="modal" class="btn btn-success" onclick="window.location='{{ url('api/deleteClan/'.$clan->id)}}'">Yes</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
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
                        <input class="search_input search_input_fixed" onkeyup="fff()" type="text" name="" placeholder="Search...">
                        <div class="search_icon"><i class="fas fa-search"></i></div>
                    </div>
                </div>
            <ul class="pl-0 users-list invite-list" data-id="{{$clan->id}}">
                    @each('partials.userCheckbox', $potentialUsers, 'user')
                    <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="invite-users btn btn-success"><i class="fas fa-user-plus"></i> Invite</button>
            </div>
        </div>
    </div>
</div>

@endsection