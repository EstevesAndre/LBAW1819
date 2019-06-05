<?php

namespace App\Http\Controllers;

use App\Post;
use App\Clan;
use App\User;
use App\Blocked;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClanController extends Controller
{
    public function showCreateClanPage()
    {
        if (!Auth::check()) return redirect('/login');       
        
        $exists = TRUE;

        if(Auth::user()->clan()->get()->isEmpty())
            $exists = FALSE;

        return $exists === FALSE ? view('pages.createClan') : redirect('clan');
    }

    public function show() 
    {
        if (!Auth::check()) return redirect('/login');       
        
        if(Auth::user()->clan()->get()->isEmpty()) {
            return view('pages.createClan');
        }

        $clan = Auth::user()->clan()->get()->first();
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
        
        $invited = $clan->invited()->get();

        $idClanMembers = [];

        foreach($members as $member)
            array_push($idClanMembers, $member->id);

        foreach($invited as $invite)
            array_push($idClanMembers, $invite->receiver()->get()[0]->id);

        foreach($blocked as $block)
            array_push($idClanMembers, $block->user()->get()[0]->id);

        $idClanMembers = array_unique($idClanMembers);

        $potentialUsers = User::whereNotIn('id', $idClanMembers)->limit(7)->get();

        return view('pages.clanSettings', ['clan' => $clan, 'members' => $members, 'blocked' => $blocked, 'potentialUsers' => $potentialUsers]);
    }

    public function update(Request $request, $id) {
        
        $clan = Clan::find($id);

        $name = $clan->name;
        $description = $clan->description;

        if($request->input('name') !== null)
            $name = $request->input('name');
        
        if($request->input('description') !== null)
            $description = $request->input('description');

        $clan->update(['name' => $name, 'description' => $description]); 

        if ($request->hasFile('clan_img')) {
            $image = $request->file('clan_img');
            $name = $id.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/clanImgs');
            $image->move($destinationPath, $name);
        }

        return redirect('clan');
    }

    public function banMember(Request $request, $id){
        
        $endDate = $request->input('endDate') == -1? null : $request->input('endDate');

        DB::table('blockeds')->insert(
            ['user_id' => $id, 'clan' =>Auth::user()->clan()->get()[0]->id, 'date' => $endDate, 'motive' => $request->input('motive')]
        );

        DB::table('user_clans')
                ->where('user_id' , $id)
                ->delete();

        $banned_member = User::find($id);

        return response()->json(['banned' => $banned_member]); 
    }

    public function unbanMember(Request $request, $user_id, $clan_id){

        Blocked::where('user_id', $user_id)->where('clan', $clan_id)->delete();

        DB::table('user_clans')->insert(['user_id' => $user_id, 'clan_id' => $clan_id]);

        $unbanned_member = User::find($user_id);

        return response()->json(['unbanned' => $unbanned_member]); 
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

    public function inviteUsers(Request $request, $clan_id){

        $invites = explode(",", $request->input('invites'));
        $owner = Auth::user()->id;

        foreach($invites as $invite){
            DB::table('requests')
            ->insert(['sender' => $owner, 'receiver' => intval($invite), 'clan_id' => $clan_id, 'type' => 'clanRequest' ,'has_accepted' => NULL]);
        }
        
        return response()->json(['invited' =>$request->input('invites')]); 
    }

    public function getActiveClansSearch(Request $request) {
        $search = $request->input('search');

        $allBans = Blocked::all();
        $idClanBanned = [];

        foreach($allBans as $banned) {
            if($banned->user()->get()->isEmpty())
                array_push($idClanBanned, $banned->clan);
        }

        $activeClansSearch = Clan::whereNotIn('id', $idClanBanned)
            ->where('name', 'like', '%' . $search . '%')
            ->get();
        
        return $activeClansSearch;
    }

    public function getBannedClansSearch(Request $request) {
        $search = $request->input('search');
        
        $allBans = Blocked::all();
        $idClanBanned = [];

        foreach($allBans as $banned) {
            if($banned->user()->get()->isEmpty())
                array_push($idClanBanned, $banned->clan);
        }

        $bannedClansSearch = Clan::whereIn('id', $idClanBanned)
            ->where('name', 'like', '%' . $search . '%')
            ->get();
        
            return $bannedClansSearch;
    }

    public function delete($clan_id){

        Clan::find($clan_id)->delete();
        
        return redirect('home');
    }

    public function xp($id) {
        $clan = Clan::find($id);

        $members = $clan->members()->get();
        $xp = 0;
        foreach($members as $member)
            $xp += $member->xp;

        return $xp;
    }

    public function leaveClan($user){
        DB::table('user_clans')->where('user_id',$user)->delete();
        return redirect('home');
    }
}
