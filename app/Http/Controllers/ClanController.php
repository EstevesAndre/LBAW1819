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
        
        return view('pages.createClan');
    }

    public function show() 
    {
        if (!Auth::check()) return redirect('/login');       
        
        $clans = DB::select('SELECT clan_id
                            FROM user_clans
                            WHERE user_clans.user_id = :ID', ['ID' => Auth::user()->id]);
              
        if(count($clans) == 0) {
            return redirect('createClanPage');
        }

        $id = $clans[0]->clan_id;

        $clan = Clan::find($id);
        $owner = User::find($clan->owner_id);

        $clanPosts = DB::table('posts')
                    ->whereNotNull('clan_id')
                    ->where('clan_id','=',$id)
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
                , ['ID' => $id]);

        $leaderboard = DB::table('users')
                ->select('id','name', 'username', 'xp')
                ->join('user_clans', 'users.id', '=', 'user_clans.user_id')
                ->where('user_clans.clan_id', $id)
                ->orderBy('xp','DESC')
                ->get();

        return view('pages.clan', ['clan' => $clan, 'owner' => $owner, 'members' => $members, 'posts' => $posts, 'leaders' => $leaderboard]);
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
