<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Shows the home page
     */
    public function showPage()
    {
        if (!Auth::check()) return redirect('/login');
        
        return view('pages.home');
    }
}
