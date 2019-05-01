<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\Comment;
use App\Share;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show($id)
    {
        if (!Auth::check()) return redirect('/login');

        $post = Post::find($id);

        $friends = DB::select('SELECT id, name
                                FROM users
                                WHERE id IN (
                                    SELECT sender
                                    FROM requests
                                    WHERE type = \'friendRequest\'
                                    AND has_accepted = true 
                                    AND receiver = :ID
                                )
                                OR 
                                id IN (
                                    SELECT receiver
                                    FROM requests
                                    WHERE type = \'friendRequest\'
                                    AND has_accepted = true 
                                    AND sender = :ID
                                )
                                ORDER BY id', ['ID' => Auth::user()->id]);

        return view('pages.post', ['post' => $post, 'friends' => $friends]);
    }

    public function create(Request $request, $id) 
    {
        $like = new Like();
        $like->post_id = $id;
        $like->user_id = Auth::user()->id;

        return $like;
    }

    public function delete(Request $request, $id) 
    {
        $post = Post::find($id);
        $like = $post->like()->where('user_id', '=', Auth::user()->id)->get();

        return $like;
    }
}
