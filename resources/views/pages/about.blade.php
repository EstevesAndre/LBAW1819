@extends('layouts.app')

@section('pageTitle', 'About')

@section('content')
<div class="row justify-content-center mt-5 ml-4 mr-4 align-self-center">
    <div class="col-md-8 align-self-center text-center">
        <img src="{{ asset('assets/logo.png') }}" class="img-fluid mt-5 mb-3 w-50" alt="logo">
    </div>

    <div class="col-md-6 mt-5 text-left">
        <h4 class="font-weight-bold">What is AlterEgo?</h4>
            <p>AlterEgo is a social network site where people can communicate with other people by posting
                information, sharing information and talking to each other. Unlike other social networks, AlterEgo's
                user's profiles do not reveal their real identities. Instead, it requires them to create a character
                (a "alter ego") in a fantasy world setting. It implements some aspects of RPG-like games such as
                clans and experience points.</p>
            <p>AlterEgo offers to its users a mix of two internet-based hobbies. It includes features from both
                traditional social networks, as well as RPG elements. Taking into consideration the popularity of
                social networking, the target audience for AlterEgo is more focused on the target audience of RPG
                games, offering them a social network on a setting familiar to them.</p>
            <p>Unlike most social networks, users in AlterEgo cannot upload profile images. Avatars are
                automatically generated using the gender, race and class selected by the user upon account creation.
                Users should not publicly reveal their identity.</p>
            <br>
            <h4>How to join?</h4>
            <p>In order to use AlterEgo, visitors must first log in into their accounts. This can be done by first
                creating an account or by logging in using an external account validated by an external API.</p>
            <br>
            <h4>What can I do as an user?</h4>
            <p>In AlterEgo, Users may befriend other users, make posts that can be seen, liked and commented, send
                private messages to their friends, be part of a single clan and gain experience by performing
                certain activities, such as making friends, writing posts and commenting them, among others.
                Different classes gain different amount of experiences for performing different tasks. There are
                leaderboards available for overall users, class specific and clans.</p>
    </div>
</div>
@endsection