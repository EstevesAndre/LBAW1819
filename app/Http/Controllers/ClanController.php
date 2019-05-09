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

        if($clans !== null)
            return redirect('clan');

        return view('pages.createClan');
    }

    public function show() 
    {
        if (!Auth::check()) return redirect('/login');       
        
        $clan = DB::table('user_clans')
                ->join('clans', 'clan_id', '=', 'id')
                ->where('user_id', Auth::user()->id)
                ->first();

        if($clan == null)
            return redirect('createClanPage');

        $owner = User::find($clan->owner_id);

        $clanPosts = DB::table('posts')
                    ->whereNotNull('clan_id')
                    ->where('clan_id','=',$clan->id)
                    ->get();
        
        $posts = [];
        foreach ($clanPosts as $post) {
            array_push($posts , Post::find($post->id));
        }

        $members = DB::select('SELECT DISTINCT users.id, users.username, users.name, requests.date, users.xp
                FROM users INNER JOIN user_clans ON users.id = user_clans.user_id INNER JOIN requests ON user_clans.clan_id = requests.clan_id
                WHERE has_accepted = true
                AND user_clans.clan_id = :ID
                AND (requests.receiver = users.id OR requests.sender = users.id)
                ORDER BY users.name'
                , ['ID' => $clan->id]);

        $leaderboard = DB::table('users')
                ->select('id','name', 'username', 'xp')
                ->join('user_clans', 'users.id', '=', 'user_clans.user_id')
                ->where('user_clans.clan_id', $clan->id)
                ->orderBy('xp','DESC')
                ->get();

        $friendsQuery = DB::select('SELECT DISTINCT u2.id
                                FROM "users" u1 INNER JOIN requests ON (requests.type = \'friendRequest\' AND (u1.id = requests.sender OR u1.id = requests.receiver)), "users" u2
                                WHERE u1.id = :ID
                                    AND requests.has_accepted = TRUE
                                    AND (   (requests.receiver = u2.id AND requests.receiver !=  u1.id)
                                            OR
                                            (requests.sender = u2.id AND requests.sender != u1.id)
                                )', ['ID' => Auth::user()->id]);
        $friendsIDs = array();
        foreach($friendsQuery as $aux) 
            $friendsIDs[] = $aux->id;

        $friends = User::select('id', 'name', 'username', 'xp')
            ->whereIn('id', $friendsIDs)
            ->orderBy('xp', 'DESC')
            ->get();

        return view('pages.clan', ['clan' => $clan, 'owner' => $owner, 'members' => $members, 'posts' => $posts, 'leaders' => $leaderboard, 'friends' => $friends]);
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
}
