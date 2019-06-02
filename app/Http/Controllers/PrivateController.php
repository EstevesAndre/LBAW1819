<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrivateController extends Controller
{
    /**
     * Shows the profile page for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function showHome()
    {
        if (!Auth::check()) return redirect('/login');

        $friendPosts = DB::select('SELECT id FROM posts 
                                    WHERE (posts.user_id IN 
                                        (SELECT sender FROM requests
                                            WHERE receiver = :ID AND has_accepted = true AND type = \'friendRequest\')
                                        OR posts.user_id IN
                                        (SELECT receiver FROM requests
                                            WHERE sender = :ID AND has_accepted = true AND type = \'friendRequest\')
                                        OR posts.user_id = :ID)
                                    AND clan_id IS NULL
                                    ORDER BY posts.date DESC'
                                    , ['ID' => Auth::user()->id]);
                
        $posts = [];
        foreach ($friendPosts as $post) {
            array_push($posts , Post::find($post->id));
        }
        
        return view('pages.home', ['posts' => $posts]);
    }

    public function showLeaderboard() 
    {
        if (!Auth::check()) return redirect('/login');

        $allUsers = DB::table('users')
            ->select('username', 'name', 'xp', 'race', 'class', 'gender')
            ->orderBy('xp', 'DESC')
            ->get();

        $userClan = Auth::user()->clan()->get()[0];

        $userFriends = Auth::user()->friends()->get();

        if($userClan !== null) {
            $clanMembers = $userClan->members()->get();

            return view('pages.leaderboard', ['clanMembers' => $clanMembers, 'global' => $allUsers, 'friends' => $userFriends]);
        }

        return view('pages.leaderboard', ['clanMembers' => null, 'global' => $allUsers, 'friends' => $userFriends]);
    }

    public function showChat() 
    {
        if (!Auth::check()) return redirect('/login');

        $friends = Auth::user()->friends();
        
        $selFriendMessages = Auth::user()->friendChatMessages($friends->first()->id);

        return view('pages.chat', ['user' => Auth::user()->id, 'friends' => $friends, 'messages' => $selFriendMessages]);
    }

    public function getNotifications() {

        $commentNotifications = DB::select('SELECT "users".name, posts.id as postid, comments.id as commentid
                                            FROM notifications INNER JOIN comments ON (notifications.comment_id = comments.id) 
                                                               INNER JOIN posts ON (comments.post_id = posts.id)
                                                               INNER JOIN "users" ON (comments.user_id = "users".id)
                                            WHERE notifications.comment_id IS NOT NULL AND 
                                                  posts.user_id = :ID ORDER BY notifications."date" asc', ['ID' => Auth::user()->id]);

        $likeNotifications = DB::select('SELECT *
                                         FROM notifications INNER JOIN posts ON (notifications.like_post_id = posts.id)
                                         WHERE notifications.like_post_id IS NOT NULL AND
                                               notifications.like_user_id IS NOT NULL AND
                                               posts.user_id = :ID  ORDER BY notifications."date" asc', ['ID' => Auth::user()->id]);
                                               
        $shareNotifications = DB::select('SELECT *
                                         FROM notifications INNER JOIN posts ON (notifications.share_post_id = posts.id)
                                         WHERE notifications.share_post_id IS NOT NULL AND
                                               notifications.share_user_id IS NOT NULL AND
                                               posts.user_id = :ID  ORDER BY notifications."date" asc', ['ID' => Auth::user()->id]);  

        return ['comments' => $commentNotifications, 'likes' => $likeNotifications, 'shares' => $shareNotifications];
    }

    public function showCreateCharacter() {
        return view('pages.createCharacter');
    }

    public function getLeaderboardGlobalSearch(Request $request) {
        $search = $request->input('search');

        $users = null;
        if($search == '')
        {
            $users = DB::table('users')
            ->select('username', 'name', 'xp', 'race', 'class', 'gender')
            ->orderBy('xp', 'DESC')
            ->limit(5)
            ->offset(3)
            ->get();
        }
        else 
        {
            $users = DB::table('users')
            ->select('username', 'name', 'xp', 'race', 'class', 'gender')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('xp', 'DESC')
            ->limit(5)
            ->get();
        }

        return ['users' => $users];
    }

    public function getLeaderboardClanSearch(Request $request) {
        $search = $request->input('search');
        
        $clan = Auth::user()->clan()->get()[0];

        if($clan == null)
            return;

        $users = null;
        if($search == '')
        {
            $users = $clan->members()
                ->orderBy('xp', 'DESC')
                ->limit(5)
                ->offset(3)
                ->get();
        }
        else 
        {
            $users = $clan->members()
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('xp', 'DESC')
                ->limit(5)
                ->get();
        }

        return ['users' => $users];
    }

    public function getLeaderboardFriendsSearch(Request $request) {
        $search = $request->input('search');
        
        $users = null;
        if($search == '')
        {
            $users = Auth::user()->friends()
                ->limit(5)
                ->offset(3)
                ->get();
        }
        else 
        {
            $users = Auth::user()->friends()
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('xp', 'DESC')
            ->limit(5)
            ->get();
        }

        return ['users' => $users];
    }
}