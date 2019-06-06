<?php

namespace App\Http\Controllers;

use App\User;
use App\Blocked;
use App\Clan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Shows the admin page
     *
     * @return Response
     */
    public function show()
    {
        if (!Auth::check()) return redirect('/login');

        if (!Auth::user()->is_admin) return redirect('/login');

        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $allBans = Blocked::all();
        
        $idUserBanned = [];
        $idClanBanned = [];
        foreach($allBans as $banned) {
            if($banned->user()->get()->isEmpty())
                array_push($idClanBanned, $banned->clan);
            else
                array_push($idUserBanned, $banned->user_id);
        }

        $activeUsers = User::whereNotIn('id', $idUserBanned)->get();
        $bannedUsers = User::whereIn('id', $idUserBanned)->get();

        $activeClans = Clan::whereNotIn('id', $idClanBanned)->get();
        $bannedClans = Clan::whereIn('id', $idClanBanned)->get();

        $admins = User::where('is_admin',TRUE)->whereNotIn('id', $idUserBanned)->get();
        $potentialAdmins = User::where('is_admin', FALSE)->whereNotIn('id', $idUserBanned)->limit(7)->get();

        return view('pages.administrator', ['activeUsers' => $activeUsers, 
                                            'bannedUsers' => $bannedUsers, 
                                            'activeClans' => $activeClans, 
                                            'bannedClans' => $bannedClans, 
                                            'admins' => $admins, 
                                            'potentialAdmins' => $potentialAdmins]);
    }

    public function getActiveAdminsSearch(Request $request) {
        $search = $request->input('search');

        $allBans = Blocked::all();
        $idUserBanned = [];
        foreach($allBans as $banned) {
            if(!$banned->user()->get()->isEmpty())
                array_push($idUserBanned, $banned->user_id);
        }

        $adminsSearch = User::where('is_admin',TRUE)
            ->whereNotIn('id', $idUserBanned)
            ->where('name', 'ilike', '%'.$search.'%')
            ->get();

        return $adminsSearch;
    }


    public function getPotentialAdminsSearch(Request $request) {
        $search = $request->input('search');

        $allBans = Blocked::all();
        $idUserBanned = [];
        foreach($allBans as $banned) {
            if(!$banned->user()->get()->isEmpty())
                array_push($idUserBanned, $banned->user_id);
        }

        $potentialAdminsSearch = User::where('is_admin',FALSE)
            ->whereNotIn('id', $idUserBanned)
            ->where('name', 'ilike', '%'.$search.'%')
            ->limit(7)
            ->get();

        return $potentialAdminsSearch;
    }
}