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
        if($post == null)
            return view('errors.404');

        $friendsQuery = DB::select('SELECT DISTINCT u2.id
            FROM "users" u1 INNER JOIN requests ON (requests.type = \'friendRequest\' AND (u1.id = requests.sender OR u1.id = requests.receiver)), "users" u2
            WHERE u1.id = :ID
                AND requests.has_accepted = TRUE
                AND (   (requests.receiver = u2.id AND requests.receiver !=  u1.id)
                        OR
                        (requests.sender = u2.id AND requests.sender != u1.id)
            )', ['ID' => Auth::user()->id]);

        $friendsIDs = array();
        foreach($friendsQuery as $aux) 
            $friendsIDs[] = $aux->id;

        $friends = User::select('id', 'name', 'username', 'xp')
            ->whereIn('id', $friendsIDs)
            ->orderBy('xp', 'DESC')
            ->get();

        return view('pages.post', ['post' => $post, 'friends' => $friends]);
    }

    public function create(Request $request)  // CHANGE has_img and clan_id hanlder
    {
        $post = new Post();
        $post->content = $request->input('content');
        $post->has_img = false;
        $post->user_id = Auth::user()->id;
        $post->clan_id = null;

        $post->save();

        return $post;
    }

    public function delete(Request $request, $id) 
    {
        $post = Post::find($id);

        if($post->user_id != Auth::user()->id)
            return response()->json(['deleted' => false, 'status' => $status ]);
        
        $post->delete();
        
        return $post;
    }
}
