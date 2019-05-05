@extends('layouts.app')

@section('content')
<br />
<br />
<div class="container justify-content-center fullscreen-3-4 my-5">
    <h1>Create Your Clan</h1>
    <div class="text-left">
        <form method="POST">
            <div class="form-group mx-auto my-5">
                <label for="clanName">Clan Name</label>
                <input type="username" name="name" class="form-control mb-3" id="clanName" placeholder="Name" required>  <!-- $_POST['name'] -->
                <label for="description">Brief Description</label>
                <textarea class="form-control mb-3" name="description" id="description" rows="8" placeholder="Description..." required></textarea>
                <label for="clanImage">Insert a clan Image</label>
                <input type="file" class="form-control-file input-file" id="clanImage" required>
            </div>
            <div class="mx-auto mt-5">
                <button type="submit" class="btn btn-secondary w-100">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection