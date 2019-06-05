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

        return view('pages.post', ['post' => $post]);
    }

    public function create(Request $request)  // CHANGE has_img and clan_id hanlder
    {
        $post = new Post();
        $post->content = $request->input('content');
        $post->has_img = false;
        $post->user_id = Auth::user()->id;
        
        if($request->input('clanID') !== "-1")
            $post->clan_id = $request->input('clanID');
        else
            $post->clan_id = null;


        $post->save();

        return response()->json([
            'post' => $post,
            'user' => Auth::user()
        ]);
    }

    public function delete(Request $request, $id) 
    {
        $post = Post::find($id);

        if($post->user_id != Auth::user()->id)
            return response()->json(['deleted' => false, 'status' => $status ]);
        
        $post->delete();
        
        return $post;
    }

    public function share(Request $request, $id) {

        $share = new Share();
        $share->user_id = Auth::user()->id;
        $share->post_id = $id;
        $share->content = $request->input('content');
        $share->save();

        return redirect('home');
    }
}
