@extends('layouts.app')

@section('content')
<br>
<br>
<div class="container mt-5">
    <h1 class="text-center"><b>Administrator's Page</b></h1>
    <div class="row admin-content py-3 px-3">
    <button type="button" class="float-right border-0 btn btn-default btn-circle" data-toggle="modal" data-target="#clan_helpModal">
            <i class="fas fa-question-circle"></i>
    </button>
    <div class="clan-page-info">
        <ul class="mt-5 nav nav-tabs" id="clan-tabs" role="tablist">
            <li class="nav-item">
                <a class="tab-title nav-link active" id="report-tab" data-toggle="tab" href="#reports" role="tab"
                    aria-controls="reports" aria-selected="true">Reports</a>
            </li>
            <li class="nav-item">
                <a class="tab-title nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab"
                    aria-controls="users" aria-selected="false">Users</a>
            </li>
            <li class="nav-item">
                <a class="tab-title nav-link" id="clans-tab" data-toggle="tab" href="#clans"
                    role="tab" aria-controls="clans" aria-selected="false">Clans</a>
            </li>
            <li class="nav-item">
                <a class="tab-title nav-link" id="admins-tab" data-toggle="tab" href="#admins"
                    role="tab" aria-controls="admins" aria-selected="false">Administrators</a>
            </li>
        </ul>     
        <div class="mt-4 tab-content" id="content">
            <div class="text-left tab-pane fade active show" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                
            </div>
            <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                
            </div>
            <div class="tab-pane fade" id="clans" role="tabpanel" aria-labelledby="clans-tab">
                
            </div>
            <div class="tab-pane fade" id="admins" role="tabpanel" aria-labelledby="admins-tab">
                
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => Auth::user()->friends()->get() ])
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
@endsection

