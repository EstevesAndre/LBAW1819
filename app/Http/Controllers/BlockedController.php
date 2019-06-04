<?php

namespace App\Http\Controllers;

use App\User;
use App\Blocked;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BlockedController extends Controller
{
    public function createBanUser(Request $request, $id) 
    {
        $block = new Blocked();
        $block->user_id = $id;
        $block->clan = null;
        $block->admin = Auth::user()->id;
        $block->date = $request->input('endDate') == -1? null : $request->input('endDate');
        $block->motive = $request->input('motive');
        //$block->save();

        return ['blocked' => $block, 'user' => User::find($id)];
    }
    
    public function createBanClan(Request $request, $id) {

    }

    public function deletebanUser(Request $request, $id) {
        
    }

    public function deletebanClan(Request $request, $id) {
        
    }
}