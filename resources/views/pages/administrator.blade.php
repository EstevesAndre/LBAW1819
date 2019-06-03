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
@endsection

