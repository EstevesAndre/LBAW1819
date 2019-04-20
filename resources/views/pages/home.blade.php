@extends('layouts.app')

@section('content')

<br />
<br />
<br />
<div class="container d-flex flex-column align-items-center" id="accordion">
    <h2 class="mb-5 mt-4 ml-4">Frequently Asked Questions</h2>
    <div class="card w-85">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed standard-text" data-toggle="collapse"
                    data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    What is AlterEgo?
                </button>
            </h5>
        </div>
        <div id="collapseOne" class="collapse ml-3" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                AlterEgo is a social network site where people can communicate with other people by posting
                information, sharing information and talking to each other. Unlike other social networks, AlterEgo's
                user's profiles do not reveal their real identities. Instead, it requires them to create a character
                (a "alter ego") in a fantasy world setting. It implements some aspects of RPG-like games such as
                clans and experience points.
            </div>
        </div>
    </div>
</div>
@endsection