<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrivateController extends Controller
{
    /**
     * Shows the profile page for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {
        if (!Auth::check()) return redirect('/login');

        $friendPosts = DB::select('SELECT id FROM posts 
                                    WHERE (posts.user_id IN 
                                        (SELECT sender FROM requests
                                            WHERE receiver = :ID AND has_accepted = true AND type = \'friendRequest\')
                                        OR posts.user_id IN
                                        (SELECT receiver FROM requests
                                            WHERE sender = :ID AND has_accepted = true AND type = \'friendRequest\')
                                        OR posts.user_id = :ID)
                                    AND clan_id IS NULL
                                    ORDER BY posts.date DESC'
                                    , ['ID' => Auth::user()->id]);
                
        $posts = [];
        foreach ($friendPosts as $post) {
            array_push($posts , Post::find($post->id));
        }
        
        return view('pages.home', ['posts' => $posts]);
    }
}