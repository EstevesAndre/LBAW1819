<?php

namespace App\Http\Controllers;

use App\User;
use App\Blocked;
use App\Post;
use App\Share;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Shows the profile page for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($username)
    {
        if (!Auth::check()) return redirect('/login');
        if (!Auth::user()->ban()->get()->isEmpty()) return redirect('/banned');

        $user = User::where('username', $username)->first();
        
        if($user == null) return view('errors.404');

        $friends = $user->friends()->get();

        $userClan = null;

        if($user->clan()->get()->count() !== 0)
            $userClan = $user->clan()->get()[0];

        $status = null;

        if($username != Auth::user()->username){

            $is_friend = Auth::user()->sent($user->id)->get();

            if($is_friend->isEmpty())
                $is_friend =  Auth::user()->requested($user->id)->get();

            if($is_friend->isEmpty()){ //not friends -> ADD AS FRIEND
                $status = 0;
            }
            else if($is_friend[0]->type == "friendRequest"){
                
                if($is_friend[0]->sender == Auth::user()->id && $is_friend[0]->has_accepted === false){//sent request refused BLOCKED REQUEST
                   $status = 1;
                } 
                else if($is_friend[0]->sender == Auth::user()->id && $is_friend[0]->has_accepted === NULL){//sent request pending CANCEL REQUEST
                    $status = 2;
                } 
                else if($is_friend[0]->receiver == Auth::user()->id && $is_friend[0]->has_accepted === NULL){//received request pending  ANSWER REQUEST
                    $status = 3;
                } 
                else if($is_friend[0]->receiver == Auth::user()->id && $is_friend[0]->has_accepted === false){//received request refused ->  ADD AS FRIEND
                    $status = 0;
                }
                else if($is_friend[0]->has_accepted == true){ //are friends REMOVE FRIENDSHIP
                    $status = 4;
                }
            }
        }
        
        return view('pages.profile', ['user' => $user, 'friends' => $friends, 'clan' => $userClan, 'status' => $status]);
    }

    public function seeMoreProfile($offset)
    {
        $init = intval($offset);
        $posts = Post::where('user_id', Auth::user()->id)->get();
        
        $shares = Share::where('user_id', Auth::user()->id)->get();
        
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
            if($list[$i]->id === NULL) //('share', Share,Post,User_Share, User_Post, Auth::user)
                $retrieve = $retrieve->push(array('share', 
                                                  $list[$i],
                                                  $list[$i]->post()->get(), 
                                                  $list[$i]->user()->get(),
                                                  $list[$i]->post()->get()[0]->user()->get(), 
                                                  Auth::user()));
            else //('post', Post,User)
                $retrieve = $retrieve->push(
                            array('post', 
                                $list[$i], 
                                $list[$i]->user()->get()
                            )
                );
        }

        
        return $retrieve;
    }
    
    public function getFriendsListSearch(Request $request, $id) 
    {
        $user = User::find($id);
        $search = $request->input('search');

        $users = null;
        if($search == '')
        {
            $users = $user->friends()
                ->limit(5)
                ->get();
        }
        else
        {
            $users = $user->friends()
                ->where('name', 'ilike', '%' . $search . '%')
                ->orderBy('xp', 'DESC')
                ->limit(5)
                ->get();
        }

        return $users;
    }

    public function getFriendsMessages(Request $request, $id) {

        $friend_messages = Auth::user()->friendChatMessages($id);

        foreach($friend_messages as $friend_message){
            $friend_message->has_been_seen =true;
            $friend_message->update();
        }

        return ['friend_info' => User::find($id), 'messages' => Auth::user()->friendChatMessages($id)];
    }

    public function getActiveUsersSearch(Request $request) {
        $search = $request->input('search');

        $allBans = Blocked::all();
        
        $idUserBanned = [];
        foreach($allBans as $banned) {
            if(!($banned->user()->get()->isEmpty()))
                array_push($idUserBanned, $banned->user_id);
        }

        $activeUsersSearch = User::whereNotIn('id', $idUserBanned)
                    ->where('name', 'ilike', '%' . $search . '%')
                    ->get();

        return $activeUsersSearch;
    }

    public function getBannedUsersSearch(Request $request) {
        $search = $request->input('search');

        $allBans = Blocked::all();
        
        $idUserBanned = [];
        foreach($allBans as $banned) {
            if(!($banned->user()->get()->isEmpty()))
                array_push($idUserBanned, $banned->user_id);
        }

        $bannedUsersSearch = User::whereIn('id', $idUserBanned)
                    ->where('name', 'ilike', '%' . $search . '%')
                    ->get();

        return $bannedUsersSearch;
    }

    public function removePermissions(Request $request, $id) {
        $user = User::find($id);

        $user->is_admin = FALSE;
        $user->update();

        return $user;
    }

    public function addPermissions(Request $request) {

        $invitedList = $request->input('invites');
        $invites = explode(",", $invitedList);

        $inviteIDs = [];
        foreach($invites as $invite) {
            array_push($inviteIDs, intval($invite));
        }
        foreach($inviteIDs as $invite){
            $user = User::find($invite);
            $user->is_admin = TRUE;
            $user->update();
        }
        
        return response()->json(['invited' => User::whereIn('id', $inviteIDs)->get()]); 
    }

    public function removeFriend($friend){

        $is_friend = Auth::user()->sent($friend)->get();
        $can_send = 0;
        
        if($is_friend->isEmpty()){
            $is_friend = Auth::user()->requested($friend)->get();
            $can_send = 1;
        }
        
        $is_friend[0]->delete();
               
        return response()->json(['can_send' => $can_send]); 

    }

    public function sendFriendRequest($friend){

        $is_friend = Auth::user()->requested($friend)->get();
       
        if(!$is_friend->isEmpty()){
           is_friend[0]->delete();
        }

        $request = new \App\Request();
        $request->sender = Auth::user()->id;
        $request->receiver = $friend;
        $request->type ='friendRequest';
        $request->save();
    }

    public function cancelFriendRequest($friend){

        Auth::user()->sent($friend)->delete();
        return response()->json(['friend' => $friend]); 
    }

    public function answerFriendRequest($friend, $accepted){

        $is_friend = Auth::user()->requested($friend)->get();

        if($accepted){
            $is_friend[0]->has_accepted = true;
        }
        else{
            $is_friend[0]->has_accepted = false;
        }

        $is_friend[0]->update();
            
        return response()->json(['accepted' => $accepted, 'friend' => $friend]); 
    }

    public function answerClanRequest($clan, $accepted){

        if($accepted){
            DB::table('user_clans')->insert(
                ['user_id' => Auth::user()->id, 'clan_id' => $clan]
            );

            $request = \App\Request::where('receiver', Auth::user()->id)->where('clan_id', $clan)->get();
            
            $request[0]->has_accepted = true;
            $request[0]->update();
        }
        else{
           \App\Request::where('receiver', Auth::user()->id)->where('clan_id', $clan)->delete();
        }

        return response()->json(['accepted'=> $accepted, 'clan' => $clan]); 
    }

    public function getMoreUserPosts(Request $request, $offset) {

        $init = intval($offset);
        $posts = Post::where('user_id', Auth::user()->id)->get();
        $shares = Share::where('user_id', Auth::user()->id)->get();
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
        for($i = $init; $i < $init + 3 && $i < count($list); $i++){
            if($list[$i]->id === NULL) //('share', Share,Post,User_Share, User_Post, Auth::user)
                $retrieve = $retrieve->push(
                        array('share', 
                            $list[$i], 
                            $list[$i]->post()->get()[0], 
                            $list[$i]->user()->get()[0],
                            $list[$i]->post()->get()[0]->user()->get()[0], 
                            Auth::user()
                        )
                );
            else //('post', Post,User)
                $retrieve = $retrieve->push(
                            array('post', 
                                $list[$i], 
                                $list[$i]->user()->get()[0]
                            )
                );
        }

        return $retrieve;
    }
}