<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Shows the profile page for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($username)
    {
        if (!Auth::check()) return redirect('/login');

        $user = User::where('username', $username)->first();
        
        if($user == null) return view('errors.404');

        $friends = $user->friends();


        $userClan = null;
        if($user->clan()->get() != null)
            $userClan = $user->clan()->get()[0];

        $chatFriends = Auth::user()->friends();
        

        return view('pages.profile', ['user' => $user, 'friends' => $friends, 'clan' => $userClan, 'chatFriends' => $chatFriends]);
    }
}