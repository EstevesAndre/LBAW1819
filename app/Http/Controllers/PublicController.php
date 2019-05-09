<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function showAboutPage()
    {
        return view('pages.about');
    }

    public function showFaqsPage()
    {
        return view('pages.faqs');
    }

    public function show404Page()
    {
        return view('errors.404');
    }
}