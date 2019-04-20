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
    <div class="card w-85">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed standard-text" data-toggle="collapse"
                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    How can I join?
                </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse ml-3" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                All you need to use AlterEgo is an internet connection and an account on this platform. You can join
                by clicking <a href="signUp.html">this</a> and following the steps!
            </div>
        </div>
    </div>
    <div class="card w-85">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed standard-text" data-toggle="collapse"
                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Is AlterEgo free?
                </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse ml-3" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                AlterEgo is currently free of charge so there is no excuse for you not to join our community!
            </div>
        </div>
    </div>
    <div class="card w-85">
        <div class="card-header" id="headingFour">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed standard-text" data-toggle="collapse"
                    data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    How do I post on AlterEgo?
                </button>
            </h5>
        </div>
        <div id="collapseFour" class="collapse ml-3" aria-labelledby="headingFour" data-parent="#accordion">
            <div class="card-body">
                To post on AlterEgo you first need to be logged in (<a href="signUp.html">click here</a> if you
                don't
                have an account yet). After verifying your credentials you will need to go to your home page and, at
                the
                top of the page, click the "Create Post" button. A very simple pop-up will appear where you can
                write your
                post and upload an image alongside it. After that, all you have to do is hit the button "Post" and
                that's it!
                Congratulations! You successfully posted on AlterEgo!
            </div>
        </div>
    </div>
    <div class="card w-85">
        <div class="card-header" id="headingFive">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed standard-text" data-toggle="collapse"
                    data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    How does the Experience Points (XP) system work?
                </button>
            </h5>
        </div>
        <div id="collapseFive" class="collapse ml-3" aria-labelledby="headingFive" data-parent="#accordion">
            <div class="card-body">
                To get more XP on your ALterEgo user account, you need to become an active user. The more you participate in this
                platform the more XP you get. Some examples of participation might be:                   
                <ul class="mt-3">
                    <li>
                        Create, comment and share posts.
                    </li>
                    <li>
                        Report abusive posts.
                    </li>
                    <li>
                        Add friends to your friends list.
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card w-85">
        <div class="card-header" id="headingSix">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed standard-text" data-toggle="collapse"
                    data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    What is a race?
                </button>
            </h5>
        </div>
        <div id="collapseSix" class="collapse ml-3" aria-labelledby="headingSix" data-parent="#accordion">
            <div class="card-body">
                A race is one of the mythical attributes representing the origin of your character, where it comes from. 
                Different origins may generate different races. It does not affect your role in the AlterEgo community. It is
                merely a suspense factor at the beginning of your journey, the creation of your character.
            </div>
        </div>
    </div>
    <div class="card w-85">
        <div class="card-header" id="headingSeven">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed standard-text" data-toggle="collapse"
                    data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    What is a clan?
                </button>
            </h5>
        </div>
        <div id="collapseSeven" class="collapse ml-3" aria-labelledby="headingSeven" data-parent="#accordion">
            <div class="card-body">
                A clan is a group of users (clan members) that share a private area between them (clan page). In
                this area the
                members may:

                <ul class="pt-3">
                    <li>
                        Post information in a forum that only other clan members can access.
                    </li>
                    Access a list of all member of the clan.
                    <li>
                        Access a leaderboard containing all the users ordered by Experience Points (XP).
                    </li>
                </ul>

                Typically, a user creates a clan (clan owner) and invites other users for membership.
                The selection criteria is totally up to the clan owner as he is the only member allowed to send
                inviations as well
                as ban current clan members.
            </div>
        </div>
    </div>
</div>
@endsection