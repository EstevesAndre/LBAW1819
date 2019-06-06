<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Share;
use App\Clan;
use App\Blocked;
use App\Like;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

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
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $friendIDs = Auth::user()->friendIDs()->get();
        
        $posts = Post::whereIn('user_id', $friendIDs)->get();
        
        $shares = Share::whereIn('user_id', $friendIDs)->get();
        
        $list = collect([]);

        foreach($posts as $post) {
            $list = $list->push($post);
        }

        foreach($shares as $share) {
            $list = $list->push($share);
        }

        $list = $list->sort(function ($a, $b) {
            if(strtotime($a->date) > strtotime($b->date))
                return -1;
            else 
                return 1;
        });

        $retrieve_list = collect([]);

        for($i = 0; $i < 3, $i < count($list); $i++)
            $retrieve_list = $retrieve_list->push($list[$i]);

        return view('pages.home', ['posts' => $retrieve_list]);
    }

    public function seeMoreHome($offset){
        $init = intval($offset);

        $friendIDs = Auth::user()->friendIDs()->get();

        $posts = Post::whereIn('user_id', $friendIDs)->get();
        
        $shares = Share::whereIn('user_id', $friendIDs)->get();
        
        $list = collect([]);

        foreach($posts as $post) {
            $list = $list->push($post);
        }

        foreach($shares as $share) {
            $list = $list->push($share);
        }

        $list = $list->sort(function ($a, $b) {
            if(strtotime($a->date) > strtotime($b->date))
                return -1;
            else
                return 1;
        });

        $retrieve = collect([]);
        for($i = $init; $i < $init + 3, $i < count($list); $i++){
            if($list[$i]->id === NULL)
                $retrieve = $retrieve->push(Share::where('user_id', $list[$i]->user_id)->where('post_id', $list[$i]->post_id)->get());
            else
                $retrieve = $retrieve->push(Post::where('id', $list[$i]->id)->get());
        }

        return $retrieve;
    }

    public function showLeaderboard() 
    {
        if (!Auth::check()) return redirect('/login');
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $allUsers = User::orderBy('xp','DESC')->get();

        $userClan = Auth::user()->clan()->get()[0];

        $userFriends = Auth::user()->friends()->get();

        $allClans = Clan::all();

        return view('pages.leaderboard', ['allClans' => $allClans, 'global' => $allUsers, 'friends' => $userFriends]);
    }

    public function showChat() 
    {
        if (!Auth::check()) return redirect('/login');
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $friends = Auth::user()->friends()->get();
        
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
            ->where('name', 'ilike', '%' . $search . '%')
            ->orderBy('xp', 'DESC')
            ->limit(5)
            ->get();
        }

        return ['users' => $users];
    }

    public function getLeaderboardClanSearch(Request $request) {
        $search = $request->input('search');
        
        $clans = null;
        if($search == '')
        {
            $clans = Clan::where('name', 'ilike', '%' . $search . '%')
            ->limit(5)
            ->offset(3)
            ->get();
        }
        else {
            $clans = Clan::where('name', 'ilike', '%' . $search . '%')
                ->limit(5)
                ->get();
        }

        return $clans;
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
            ->where('name', 'ilike', '%' . $search . '%')
            ->orderBy('xp', 'DESC')
            ->limit(5)
            ->get();
        }

        return ['users' => $users];
    }

    public function showSearchPage(Request $data){
        if (!Auth::check()) return redirect('/login');
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $users = User::where('name', 'ilike', '%'.$data['search'].'%')->orWhere('username', 'ilike','%'.$data['search'].'%')->limit(10)->get();
        $posts = Post::where('content', 'ilike', '%'.$data['search'].'%')->limit(10)->get();

        return view('pages.search', ['search' => $data['search'], 'users' => $users, 'posts' =>$posts]);
    }

    public function showBannedPage()
    {
        if (!Auth::check()) return redirect('/login');

        return view('pages.banned', ['user' => Auth::user(), 'ban' => Auth::user()->ban()->get()[0], 'admin' => Auth::user()->where('id', Auth::user()->ban()->get()[0]->admin)->get()[0]]);
    }
}