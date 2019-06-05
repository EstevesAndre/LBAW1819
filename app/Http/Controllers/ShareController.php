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

        $share = Share::where('post_id', '=', $post_id)->where('user_id', '=', $user_id)->get()[0];
        if($share == null)
            return view('errors.404');

        return view('pages.share', ['share' => $share]);
    }
}
