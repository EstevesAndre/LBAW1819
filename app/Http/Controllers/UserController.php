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

        $friends = User::getUserFriends(Auth::user()->id);

        $userClan = DB::table('clans')
                        ->join('user_clans', 'user_clans.clan_id', '=', 'clans.id')
                        ->select('clans.*')
                        ->where('user_clans.user_id', '=', $user->id)
                        ->orWhere('clans.owner_id', '=',$user->id)
                        ->distinct()
                        ->first();

        

        return view('pages.profile', ['user' => $user, 'friends' => $friends, 'clan' => $userClan]);
    }
}