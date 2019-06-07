<?php

namespace App\Http\Controllers;

use App\Post;
use App\Share;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function show($post_id, $user_id)
    {
        if (!Auth::check()) return redirect('/login');
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $share = Share::where('post_id', '=', $post_id)->where('user_id', '=', $user_id)->get()[0];
        if($share == null)
            return view('errors.404');

        return view('pages.share', ['share' => $share]);
    }

    public function delete(Request $request, $id) 
    {
        $ids = explode("-", $id);
        
        $share = Share::where('post_id', $ids[0])->where('user_id', $ids[1])->get()[0];

        if($share->user_id != Auth::user()->id && !Auth::user()->is_admin)
            return response()->json(['deleted' => false]);
        
        $share->delete();
        
        return $share;
    }
}
