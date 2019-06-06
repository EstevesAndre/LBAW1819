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
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $post = Post::find($id);
        if($post == null)
            return view('errors.404');

        return view('pages.post', ['post' => $post]);
    }

    public function create(Request $request)  // CHANGE has_img and clan_id hanlder
    {
        $post = new Post();
        $post->content = $request->input('content');
        if($request->hasFile('has_img')){
            $post->has_img = true;
        }
        else{
            $post->has_img = false;
        }
        
        $post->user_id = Auth::user()->id;
        
        if($request->input('clan_id') !== "-1")
            $post->clan_id = $request->input('clan_id');
        else
            $post->clan_id = null;

        $post->save();
        $post->refresh();

        if ($request->hasFile('has_img')) {
            $image = $request->file('has_img');
            $name = $post->id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/postImgs');
            $image->move($destinationPath, $name);
        }

        return view('pages.post', ['post' => $post]);
    }

    public function delete(Request $request, $id) 
    {
        $post = Post::find($id);

        if($post->user_id != Auth::user()->id && !Auth::user()->is_admin)
            return response()->json(['deleted' => false]);
        
        $post->delete();
        
        return $post;
    }

    public function share(Request $request, $id) {

        $share = new Share();
        $share->user_id = Auth::user()->id;
        $share->post_id = $id;
        $share->content = $request->input('content');
        $share->save();

        return redirect()->action(
            'ShareController@show', ['post_id' => $share->post_id, 'user_id' => $share->user_id]
        );
    }
}
