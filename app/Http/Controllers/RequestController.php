<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function show()
    {
        if (!Auth::check()) return redirect('/login');

        $sent = Auth::user()->allSent()->get();

        $received =Auth::user()->allRequested()->get();

        $clans = Auth::user()->allClanRequests()->get();

        return view('pages.friendRequests', ['sent' => $sent, 'received' => $received, 'clans' => $clans]);
    }
}