<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function create(Request $request, $id) 
    {
        $like = new Like();
        $like->post_id = $id;
        $like->user_id = Auth::user()->id;
        $like->save();

        $user = User::find($like->user_id);
        $user->xp = $user->xp + 5;
        $user->save();

        $owner = User::find($like->post()->get()[0]->user()->get()[0]->id);
        $owner->xp = $owner->xp + 10;
        $owner->save();

        return $like;
    }

    public function delete(Request $request, $id) 
    {
        $status = Like::where('user_id', Auth::user()->id)->where('post_id', $id)->delete();

        $user = User::find(Auth::user()->id);
        $user->xp = $user->xp - 5;
        $user->save();

        $owner = User::find(Post::find($id)->user()->get()[0]->id);
        $owner->xp = $owner->xp - 10;
        $owner->save();

        return response()->json([
            'post_id' => $id,
            'status' => $status
        ]);
    }
}
