<?php

namespace App\Http\Controllers;

use App\User;
use App\Blocked;

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
                else if($is_friend[0]->receiver == Auth::user()->id && $is_friend[0]->has_accepted === false){///received request refused ->  ADD AS FRIEND
                    $status = 0;
                }
                else if($is_friend[0]->has_accepted == true){ //are friends REMOVE FRIENDSHIP
                    $status = 4;
                }
            }
        }
        
        return view('pages.profile', ['user' => $user, 'friends' => $friends, 'clan' => $userClan, 'status' => $status, 'is_friend' => $is_friend]);
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
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('xp', 'DESC')
                ->limit(5)
                ->get();
        }

        return $users;
    }

    public function getFriendsMessages(Request $request, $id) {
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
                    ->where('name', 'like', '%' . $search . '%')
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
                    ->where('name', 'like', '%' . $search . '%')
                    ->get();

        return $bannedUsersSearch;
    }

    public function removePermissions(Request $request, $id) {
        $user = User::find($id);

        $user->is_admin = FALSE;
        $user->update();

        return $user;
    }

    public function addPermissions(Request $request, $id) {
        $user = User::find($id);

        $user->is_admin = TRUE;
        $user->update();

        return $user;
    }

    public function removeFriend($friend){

        $is_friend = Auth::user()->sent($friend)->get();
        $can_send = 0;
        
        if($is_friend->isEmpty()){
            $is_friend = Auth::user()->requested($friend)->get();
            $can_send = 1;
        }

        // $is_friend[0]->has_accepted = false;
        // $is_friend[0]->update();
               
        return response()->json(['can_send' => $can_send]); 

    }

    public function sendFriendRequest($friend){

        $request = new \App\Request();
        $request->sender = Auth::user()->id;
        $request->receiver = $friend;
        $request->type ='friendRequest';
        $request->save();
    }

    public function cancelFriendRequest($friend){

        $is_friend = Auth::user()->sent($friend)->delete();
    }

    public function answerFriendRequest($friend, $accepted){

        $is_friend = Auth::user()->sent($friend)->get();

        // if($accepted){
        //     $is_friend[0]->has_accepted = true;
        // }
        // else{
        //     $is_friend[0]->has_accepted = false;
        // }

        // $is_friend[0]->update();

            
        return response()->json(['accepted' => $accepted]); 
    }

}