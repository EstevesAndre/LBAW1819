<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;

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

        $user = User::find($comment->user_id);
        $user->xp = $user->xp + 10;
        $user->save();

        $owner = User::find($comment->post()->get()[0]->user()->get()[0]->id);
        $owner->xp = $owner->xp + 20;
        $owner->save();

        return response()->json(['id' => $comment->id, 'post_id' => $id, 'user_id' => Auth::user()->id, 'comment_text' => $request->input('comment'), 'gender' =>  Auth::user()->gender, 'race' => Auth::user()->race,  'class' => Auth::user()->class, 'username' => Auth::user()->username ]);
    }

    public function delete(Request $request, $id) 
    {
        $comment = Comment::find($id);

        if($comment->post_id != Auth::user()->id && !Auth::user()->is_admin)
            return response()->json(['deleted' => false, 'status' => $status ]);
        
        $user = User::find($comment->user_id);
        $user->xp = $user->xp - 10;
        $user->save();

        $owner = User::find($comment->post()->get()[0]->user()->get()[0]->id);
        $owner->xp = $owner->xp - 20;
        $owner->save();

        $comment->delete();
        
        return $comment;
    }
}
