<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Shows the home page
     */
    public function showPage()
    {
        if (!Auth::check()) return redirect('/login');
        
        return view('pages.user');
    }

    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        $this->authorize('show', $post);

        return view('pages.card', ['card' => $card]);
    }
}
