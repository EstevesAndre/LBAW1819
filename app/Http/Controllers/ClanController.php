<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClanController extends Controller
{

    public function showCreateClanPage()
    {
	 if (!Auth::check()) return redirect('/login');       
	
	 return view('pages.createClan');
    }
}
