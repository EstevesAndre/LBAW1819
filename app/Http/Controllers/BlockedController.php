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
        $block->save();

        return response()->json(['blocked' => $block, 'user' => User::find($id)]);
    }
    
    public function createBanClan(Request $request, $id) {

    }

    public function deletebanUser(Request $request, $id) {
        if(Auth::user()->is_admin == FALSE)
            return response()->json(['deleted' => false, 'status' => $status ]);
        
        $status = Blocked::where('user_id', $id)->first()->delete();

        return response()->json(['deleted' => true, 'status' => $status, 'user' => User::find($id)]);
    }

    public function deletebanClan(Request $request, $id) {
        
    }
}