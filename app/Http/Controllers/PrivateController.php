<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Share;
use App\Clan;
use App\Blocked;
use App\Like;
use App\Notification;
use App\Comment;

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
        
        return view('pages.home', ['posts' => $list->take(3)]);
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
            if($list[$i]->id === NULL) //('share', Share,Post,User_Share, User_Post)
                $retrieve = $retrieve->push(array('share', Share::where('user_id', $list[$i]->user_id)->where('post_id', $list[$i]->post_id)->get(), $list[$i]->post() , $list[$i]->user()->get(),$list[$i]->post()->get()[0]->user()->get()));
            else //('post', Post,User)
                $retrieve = $retrieve->push(array('post', Post::where('id', $list[$i]->id)->get(), $list[$i]->user()->get()));
        }

        return $retrieve;
    }

    public function showLeaderboard() 
    {
        if (!Auth::check()) return redirect('/login');
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $allUsers = User::orderBy('xp','DESC')->get();

        $userFriends = Auth::user()->friends()->get();

        $allClans = Clan::all();

        $allXP = collect([]);

        foreach($allClans as $clan){
            $allXP = $allXP->push($clan->getXP());
        }

        $clanAllInfo = array();

        for($i = 0; $i < count($allClans); $i++){
           array_push( $clanAllInfo, array($allClans[$i],$allXP[$i]));
        }

        usort($clanAllInfo, function ($a, $b) {
            if($a[1] > $b[1])
                return -1;
            else
                return 1;
        });        

        return view('pages.leaderboard', ['clans' => $clanAllInfo, 'global' => $allUsers, 'friends' => $userFriends]);
    }

    public function showChat() 
    {
        if (!Auth::check()) return redirect('/login');
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $friends = Auth::user()->friends()->get();

        $selFriendMessages = collect([]);

        if(!$friends->isEmpty()){
            $selFriendMessages = Auth::user()->friendChatMessages($friends->first()->id);
        }

        foreach($selFriendMessages as $friend_message){
            $friend_message->has_been_seen =true;
            $friend_message->update();
        }

        return view('pages.chat', ['user' => Auth::user()->id, 'friends' => $friends, 'messages' => $selFriendMessages]);
    }

    public function getNotifications() {
        return Auth::user()->getNotifications();
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

    public function notificationSeen(Request $request, $id) {
        $notification = Notification::find($id);
        $notification->has_been_seen = TRUE;
        $notification->update();

        return $notification;
    }
}