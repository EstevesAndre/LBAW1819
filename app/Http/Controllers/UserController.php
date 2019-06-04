<?php

namespace App\Http\Controllers;

use App\User;
use App\Blocked;

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

        $friends = $user->friends()->get();

        $userClan = null;
        if($user->clan()->get() != null)
            $userClan = $user->clan()->get()[0];

        return view('pages.profile', ['user' => $user, 'friends' => $friends, 'clan' => $userClan]);
    }
    
    public function getFriendsListSearch(Request $request, $id) 
    {
        $user = User::find($id);
        $search = $request->input('search');

        $users = null;
        if($search == '')
        {
            $users = $user->friends()
                ->limit(5)
                ->get();
        }
        else
        {
            $users = $user->friends()
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('xp', 'DESC')
                ->limit(5)
                ->get();
        }

        return $users;
    }

    public function getFriendsMessages(Request $request, $id) {
        return ['friend_info' => User::find($id), 'messages' => Auth::user()->friendChatMessages($id)];
    }

    public function getActiveUsersSearch(Request $request) {
        $search = $request->input('search');

        $allBans = Blocked::all();
        
        $idUserBanned = [];
        foreach($allBans as $banned) {
            if(!($banned->user()->get()->isEmpty()))
                array_push($idUserBanned, $banned->user_id);
        }

        $activeUsersSearch = User::whereNotIn('id', $idUserBanned)
                    ->where('name', 'like', '%' . $search . '%')
                    ->get();

        return $activeUsersSearch;
    }

    public function getBannedUsersSearch(Request $request) {
        $search = $request->input('search');

        $allBans = Blocked::all();
        
        $idUserBanned = [];
        foreach($allBans as $banned) {
            if(!($banned->user()->get()->isEmpty()))
                array_push($idUserBanned, $banned->user_id);
        }

        $bannedUsersSearch = User::whereIn('id', $idUserBanned)
                    ->where('name', 'like', '%' . $search . '%')
                    ->get();

        return $bannedUsersSearch;
    }

}