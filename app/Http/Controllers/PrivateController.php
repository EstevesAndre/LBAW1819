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

        $friends = User::getUserFriends(Auth::user()->id);
        
        return view('pages.home', ['posts' => $posts, 'friends' => $friends]);
    }

    public function showLeaderboard() 
    {
        if (!Auth::check()) return redirect('/login');

        $allUsers = DB::table('users')
            ->select('username', 'name', 'xp')
            ->orderBy('xp', 'DESC')
            ->get();

        $friends = User::getUserFriends(Auth::user()->id);

        $userClan = DB::table('clans')
            ->join('user_clans', 'user_clans.clan_id', '=', 'clans.id')
            ->select('clans.*')
            ->where('user_clans.user_id', '=', Auth::user()->id)
            ->orWhere('clans.owner_id', '=',Auth::user()->id)
            ->distinct()
            ->first();

        if($userClan !== null) {
            $clanMembers = DB::table('users')
                ->join('user_clans', 'user_clans.user_id', '=', 'users.id')
                ->select('users.username', 'users.name', 'users.xp')
                ->where('user_clans.clan_id', $userClan->id)
                ->orderBy('users.xp', 'DESC')
                ->get();

            return view('pages.leaderboard', ['friends' => $friends, 'clanMembers' => $clanMembers, 'global' => $allUsers]);
        }

        return view('pages.leaderboard', ['friends' => $friends, 'clanMembers' => null, 'global' => $allUsers]);
    }

    public function showChat() 
    {
        if (!Auth::check()) return redirect('/login');

        $friends = DB::select('SELECT DISTINCT u2.id, u2.username, u2.name, u2.xp, requests.date 
                                FROM "users" u1 INNER JOIN requests ON (requests.type = \'friendRequest\' AND (u1.id = requests.sender OR u1.id = requests.receiver)), "users" u2
                                WHERE u1.id = :ID
                                    AND requests.has_accepted = TRUE
                                    AND (   (requests.receiver = u2.id AND requests.receiver !=  u1.id)
                                            OR
                                            (requests.sender = u2.id AND requests.sender != u1.id)
                                )', ['ID' => Auth::user()->id]);

        $selFriend = head($friends)->id;

        $selFriendMessages = DB::select('SELECT sender,receiver,"date",message_text
                                         FROM messages
                                         WHERE (receiver = :FID AND sender = :ID) OR
                                               (receiver = :ID AND sender = :FID) 
                                        ORDER BY "date"', ['ID' => Auth::user()->id, 'FID' => $selFriend]);

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
}