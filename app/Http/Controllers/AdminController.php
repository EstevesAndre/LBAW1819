<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Shows the admin page
     *
     * @return Response
     */
    public function show()
    {
        if (!Auth::check()) return redirect('/login');

        if (!Auth::user()->is_admin) return redirect('/login');

        return view('pages.administrator');
    }
}