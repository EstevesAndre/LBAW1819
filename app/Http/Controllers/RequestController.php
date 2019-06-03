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

        $sent = DB::table('requests')
            ->where('type','friendRequest')
            ->where('sender',Auth::user()->id)
            ->where('has_accepted', null)
            ->get();

        $received = DB::table('requests')
            ->where('type','friendRequest')
            ->where('receiver',Auth::user()->id)
            ->where('has_accepted', null)
            ->get();

        $rejected = DB::table('requests')
            ->where('type','friendRequest')
            ->where('receiver',Auth::user()->id)
            ->where('has_accepted', true)
            ->get();

        return view('pages.friendRequests', ['sent' => $sent, 'received' => $received, 'rejected' => $rejected]);
    }
}