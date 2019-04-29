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

    public function show($id = null) 
    {
        if (!Auth::check()) return redirect('/login');       

        if($id === null)
        {
            $clan = Clan::find(1);
            return view('pages.clan', ['clan' => $clan]);
        }
        else 
        {
            $clan = Clan::find($id);
            $owner = User::find($clan->owner_id);
            $members = DB::select('SELECT user_id FROM user_clans WHERE clan_id = :ID', ['ID' => $id]);
            $clanPosts = DB::table('posts')
                        ->whereNotNull('clan_id')
                        ->where('clan_id','=',$id)
                        ->get();
            
            $posts = [];
            foreach ($clanPosts as $post) {
                array_push($posts , Post::find($post->id));
            }
            $members = DB::table('users')
                        ->join('user_clans', 'users.id', '=', 'user_clans.user_id')
                        ->join('requests', 'user_clans.clan_id', '=', 'requests.clan_id')
                        ->where('user_clans.clan_id', '=', $id)
                        ->where('has_accepted', '=', 'true')
                        ->get();
             /*
             
                        SELECT * 
                        FROM users INNER JOIN user_clans ON users.id = user_clans.user_id INNER JOIN requests ON user_clans.clan_id = requests.clan_id
                        WHERE user_clans.clan_id = 6
AND has_accepted = true
AND (receiver = users.id OR sender = users.id)
 */

            return view('pages.clan', ['clan' => $clan, 'owner' => $owner, 'members' => $members, 'posts' => $posts]);
        }

    }
}
