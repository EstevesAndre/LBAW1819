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


        $friendsQuery = DB::select('SELECT DISTINCT u2.id
            FROM "users" u1 INNER JOIN requests ON (requests.type = \'friendRequest\' AND (u1.id = requests.sender OR u1.id = requests.receiver)), "users" u2
            WHERE u1.id = :ID
                AND requests.has_accepted = TRUE
                AND (   (requests.receiver = u2.id AND requests.receiver !=  u1.id)
                        OR
                        (requests.sender = u2.id AND requests.sender != u1.id)
            )', ['ID' => Auth::user()->id]);

        $friendsIDs = array();
        foreach($friendsQuery as $aux) 
            $friendsIDs[] = $aux->id;

        $friends = User::select('id', 'name', 'username', 'xp')
            ->whereIn('id', $friendsIDs)
            ->orderBy('xp', 'DESC')
            ->get();

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