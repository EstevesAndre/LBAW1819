<?php

namespace App\Http\Controllers;

use App\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request, $id) 
    {
        $comment = new Comment();
        $comment->post_id = $id;
        $comment->user_id = Auth::user()->id;
        $comment->comment_text =  $request->input('comment');
        $comment->save();

        return $comment;
    }

    public function delete(Request $request, $id) 
    {
        $comment = Comment::find($id);

        if($comment->post_id != Auth::user()->id && !Auth::user()->is_admin)
            return response()->json(['deleted' => false, 'status' => $status ]);
        
        $comment->delete();
        
        return $comment;
    }
}
