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
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');
        
        $exists = TRUE;

        if(Auth::user()->clan()->get()->isEmpty())
            $exists = FALSE;

        return $exists === FALSE ? view('pages.createClan') : redirect('clan');
    }

    public function show() 
    {
        if (!Auth::check()) return redirect('/login');       
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');
        
        if(Auth::user()->clan()->get()->isEmpty()) {
            return view('pages.createClan');
        }

        $clan = Auth::user()->clan()->get()->first();
        $members = $clan->members()->get();
        $leaders = $clan->members()->orderBy('xp', 'desc')->get();
        $posts = $clan->posts()->orderBy('date', 'desc')->limit(3)->get();

        return view('pages.clan', ['clan' => $clan, 'members' => $members, 'leaders' => $leaders, 'posts' => $posts]);
    }

    public function showClan(Request $request, $id) {
        if (!Auth::check()) return redirect('/login');
        if (!Auth::user()->is_admin) return redirect('clan');

        $clan = Clan::find($id);
        $members = $clan->members()->get();
        $leaders = $clan->members()->orderBy('xp', 'desc')->get();
        $posts = $clan->posts()->orderBy('date', 'desc')->limit(5)->get();

        return view('pages.clan', ['clan' => $clan, 'members' => $members, 'leaders' => $leaders, 'posts' => $posts]);
    }


    public function seeMoreClan($offset) {

        $init = intval($offset);

        $posts = Auth::user()->clan()->get()[0]->posts()->orderBy('date', 'desc')->get();

        $retrieve = collect([]);
        for($i = 0; $i < count($posts); $i++){
            $retrieve = $retrieve->push(
                        array('post', 
                            $posts[$i], 
                            $posts[$i]->user()->get()
                        )
            );
        }
        
        return $retrieve;
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
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');
        
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
                ->where('name', 'ilike', '%'. $search. '%')
                ->orderBy('xp', 'DESC')
                ->limit(7)
                ->get();
        }
        
        return $members;
    }

    public function getActiveClanUsersSearch(Request $request, $id) {

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
                ->where('name', 'ilike', '%'. $search. '%')
                ->orderBy('xp', 'DESC')
                ->limit(7)
                ->get();
        }
        
        return response()->json(['users' => $members, 'userID' => Auth::user()->id]); 
    }

    public function inviteUsers(Request $request, $clan_id){

        $invites = explode(",", $request->input('invites'));
        $owner = Auth::user()->id;

        foreach($invites as $invite){
            DB::table('requests')
                ->insert(['sender' => $owner, 'receiver' => intval($invite), 'clan_id' => $clan_id, 'type' => 'clanRequest' ,'has_accepted' => NULL]);
        }
        
        return response()->json(['invited' => $request->input('invites')]); 
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
            ->where('name', 'ilike', '%' . $search . '%')
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
            ->where('name', 'ilike', '%' . $search . '%')
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

    public function getBannedClanUsersSearch(Request $request, $id) {

        $search = $request->input('search');
        $clanBlocked = Blocked::where('clan', $id)
            ->whereNotNull('user_id')
            ->get();

        $idUsersBanned = [];
        foreach($clanBlocked as $banned) {
            array_push($idUsersBanned, $banned->user_id);
        }

        $users = null;

        if($search == '')
        {
            $users = User::whereIn('id', $idUsersBanned)
                ->get();
        }
        else
        {
            $users = User::whereIn('id', $idUsersBanned)
                ->where('name', 'ilike', '%' . $search . '%')
                ->get();
        }

        return $users;
    }

    public function getPotentialClanUsersSearch(Request $request, $id) {
        $clan = Clan::find($id);
        $idClanMembers = [];
        $search = $request->input('search');

        foreach($clan->members()->get() as $member)
            array_push($idClanMembers, $member->id);
        foreach($clan->invited()->get() as $invite)
            array_push($idClanMembers, $invite->receiver()->get()[0]->id);
        foreach($clan->blocked()->get() as $block)
            array_push($idClanMembers, $block->user()->get()[0]->id);

        $idClanMembers = array_unique($idClanMembers);

        $users = null;
        if($search == '')
        {
            $users = User::whereNotIn('id', $idClanMembers)
                    ->limit(8)
                    ->get();
        }
        else
        {
            $users = User::whereNotIn('id', $idClanMembers)
                ->where('name', 'ilike', '%' . $search . '%')
                ->limit(8)
                ->get();
        }

        return $users;
    }
}
