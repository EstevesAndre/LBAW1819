<?php

namespace App\Http\Controllers;

use App\Post;
use App\Clan;

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

    public function show($id = null) 
    {
        if (!Auth::check()) return redirect('/login');       

        if($id === null)
        {
            $clan = Clan::find(1);

            return view('pages.clan', ['clan' => $clan]);
        }
        else 
        {
            $clan = Clan::find($id);

            return view('pages.clan', ['clan' => $clan]);
        }

    }
}
