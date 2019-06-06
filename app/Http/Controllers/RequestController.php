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
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');
        
        $sent = Auth::user()->allSent()->get();

        // $sent = DB::table('requests')
        //     ->where('type','friendRequest')
        //     ->where('sender',Auth::user()->id)
        //     ->where('has_accepted', null)
        //     ->get();

        $received =Auth::user()->allRequested()->get();


        // $received = DB::table('requests')
        //     ->where('type','friendRequest')
        //     ->where('receiver',Auth::user()->id)
        //     ->where('has_accepted', null)
        //     ->get();

        return view('pages.friendRequests', ['sent' => $sent, 'received' => $received]);
    }
}