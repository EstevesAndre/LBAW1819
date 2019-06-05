@extends('layouts.app')

@section('pageTitle', 'Create Clan')

@section('content')
<br />
<br />
<div class="container justify-content-center fullscreen-3-4 my-5">
    <h1>Create Your Clan</h1>
    <button type="button" class="border-0 btn btn-default rounded-circle" data-toggle="modal" data-target="#createclan_helpModal">
            <i class="fas fa-question-circle"></i>
    </button>
    <div class="text-left">
        <form method="POST" action="/api/createClan">
            {{csrf_field()}}
            <div class="form-group mx-auto my-5">
                <label for="clanName">Clan Name</label>
                <input type="username" name="name" class="form-control mb-3" id="clanName" placeholder="Name" required>  <!-- $_POST['name'] -->
                <label for="description">Brief Description</label>
                <textarea class="form-control mb-3" name="description" id="description" rows="8" placeholder="Description..." required></textarea>
                <label for="clanImage">Insert a clan Image</label>
                <input type="file" class="form-control-file input-file" id="clanImage">
            </div>
            <div class="mx-auto mt-5">
                <button type="submit" class="btn btn-secondary w-100">Create</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createclan_helpModal" tabindex="-1" role="dialog" aria-labelledby="createclan_helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createclan_helpModalLabel">Create Clan Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This is the create clan page.
            </div>
        </div>
    </div>
</div>
@endsection