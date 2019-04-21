<?php

namespace App\Http\Controllers;

class PublicController extends Controller
{

    public function showCreateClanPage()
    {
        return view('pages.createClan');
    }
}