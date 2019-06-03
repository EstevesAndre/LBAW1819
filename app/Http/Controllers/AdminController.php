<?php

namespace App\Http\Controllers;

use App\User;
use App\Blocked;

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

        $bannedUsers = Blocked::all();
        
        $idBanned = [];
        foreach($bannedUsers as $banned)
            array_push($idBanned, $banned->user_id);

        $activeUsers = User::whereNotIn('id', $idBanned)->get();

        return view('pages.administrator', ['activeUsers' => $activeUsers, 'bannedUsers' => $bannedUsers]);
    }
}