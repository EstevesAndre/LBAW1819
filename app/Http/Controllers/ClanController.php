<?php

namespace App\Http\Controllers;

use App\Post;
use App\Clan;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClanController extends Controller
{
    public function showCreateClanPage()
    {
        if (!Auth::check()) return redirect('/login');       
        
        $clans = DB::table('user_clans')
                ->where('user_id', Auth::user()->id)
                ->first();

        return $clans === null ? view('pages.createClan'): redirect('clan');
    }

    public function show() 
    {
        if (!Auth::check()) return redirect('/login');       
        
        $clan = Auth::user()->clan()->get()[0];

        $members = $clan->members()->get();

        $owner = $clan->owner()->get()[0];

        $posts = $clan->posts()->orderBy('date', 'desc')->limit(5)->get();

        return view('pages.clan', ['clan' => $clan, 'owner' => $owner, 'members' => $members, 'posts' => $posts]);
    }

    public function create(Request $request)
    {
        $clan = new Clan();
        $clan->name = $request->input('name');
        $clan->description = $request->input('description');
        $clan->owner_id = Auth::user()->id;
        $clan->save();

        DB::table('user_clans')->insert(
            ['user_id' => Auth::user()->id, 'clan_id' => $clan->id]
        );

        return redirect('clan');
    }

    public function showClanSettings(){
        
        if (!Auth::check()) return redirect('/login');  
        
        $clan = DB::table('user_clans')
            ->join('clans', 'clan_id', '=', 'id')
            ->where('user_id', Auth::user()->id)
            ->first();

        $clan2 = Clan::find($clan->id);

        if($clan->owner_id != Auth::user()->id) return;

        return view('pages.clanSettings', ['clan' => $clan, 'clan2' =>$clan2]);
    }

    public function update(Request $request){
        return redirect('clan');
    }
}
