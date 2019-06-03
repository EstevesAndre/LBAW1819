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

        $leaders = $clan->members()->orderBy('xp', 'desc')->get();

        $posts = $clan->posts()->orderBy('date', 'desc')->limit(5)->get();

        return view('pages.clan', ['clan' => $clan, 'members' => $members, 'leaders' => $leaders, 'posts' => $posts]);
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
        
        $clan = Auth::user()->clan()->get()[0];  

        $owner = $clan->owner()->get()[0];
        
        if($owner->id != Auth::user()->id) return;

        $members = $clan->members()->get();

        $blocked = $clan->blocked()->get();

        return view('pages.clanSettings', ['clan' => $clan, 'members' => $members, 'blocked' => $blocked]);
    }

    public function update(Request $request, $id){
        
        DB::table('clans')
                ->where('id', $id)
                ->update(['name' => $request->input('name'), 'description' => $request->input('description')]);

        if ($request->hasFile('clan_img')) {
            $image = $request->file('clan_img');
            $name = $id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/clanImgs');
            $image->move($destinationPath, $name);
        }

        return redirect('clan');
    }

    public function getClanSearch(Request $request, $id) {

        $clan = Clan::find($id);
        $search = $request->input('search');

        $members = null;
        if($search == '')
        {
            $members = $clan->members()
                ->orderBy('xp', 'DESC')
                ->limit(7)
                ->get();
        }
        else
        {
            $members = $clan->members()
                ->where('name', 'like', '%'. $search. '%')
                ->orderBy('xp', 'DESC')
                ->limit(7)
                ->get();
        }

        return $members;
    }
}
