<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\Comment;
use App\Share;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Shows the home page
     */
    public function showPage()
    {
        if (!Auth::check()) return redirect('/login');
        
        return view('pages.home');
    }

    public function show($id)
    {
        if (!Auth::check()) return redirect('/login');

        $post = Post::find($id);

        return view('pages.post', ['post' => $post]);
    }
}
