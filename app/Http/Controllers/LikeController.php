<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;

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

        return $like;
    }

    public function delete(Request $request, $id) 
    {
        $status = Like::where('user_id', Auth::user()->id)->where('post_id', $id)->delete();

        return response()->json([
            'post_id' => $id,
            'status' => $status
        ]);
    }
}
