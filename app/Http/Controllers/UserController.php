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
    public function show($id)
    {
        if (!Auth::check()) return redirect('/login');

        $user = User::find($id);
        
        if($user == null) return view('errors.404');

        $friends = DB::select('SELECT u2.id, u2.name, requests.date 
                                FROM "users" u1 INNER JOIN requests ON (requests.type = \'friendRequest\' AND (u1.id = requests.sender OR u1.id = requests.receiver)), "users" u2
                                WHERE u1.id = :ID
                                    AND requests.has_accepted = TRUE
                                    AND (   (requests.receiver = u2.id AND requests.receiver !=  u1.id)
                                            OR
                                            (requests.sender = u2.id AND requests.sender != u1.id)
                                )
                                ORDER BY requests.date DESC', ['ID' => $id]);

        return view('pages.profile', ['user' => $user, 'friends' => $friends]);
    }
}