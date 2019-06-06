<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'race', 'class', 'gender', 'birthdate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The posts this user owns.
     */
    public function posts() {
        $posts = Post::where('user_id', $this->id)->get();
        
        $shares = Share::where('user_id', $this->id)->get();
        
        $list = collect([]);

        foreach($posts as $post) {
            $list = $list->push($post);
        }

        foreach($shares as $share) {
            $list = $list->push($share);
        }

        $list = $list->sort(function ($a, $b) {
            if(strtotime($a->date) > strtotime($b->date))
            {
                return -1;
            }
            else 
            {
                return 1;
            }
        });
        return $list;
    }

    public function likes() {
        return $this->hasMany('App\Like', 'id', 'user_id');   
    }

    public function clan() {
        return $this->belongsToMany('App\Clan', 'user_clans', 'user_id', 'clan_id');
    }

    public function requests() {
        return $this->hasMany('App\Request', 'sender', 'id')->where('type','friendRequest');
    }
 
    public function messages($userID) {
        return $this->hasMany('App\Message', 'sender', 'id')->where('receiver', $userID);
    }

    public function requested($id) {
        return $this->hasOne('App\Request', 'receiver', 'id')->where('sender',$id)->where('type','friendRequest');
    }

    public function sent($id) {
        return $this->hasOne('App\Request', 'sender', 'id')->where('receiver',$id)->where('type','friendRequest');
    }

    public function allRequested() {
        return $this->hasMany('App\Request', 'receiver', 'id')->where('has_accepted', null)->where('type','friendRequest');
    }

    public function allClanRequests() {
        return $this->hasMany('App\Request', 'receiver', 'id')->where('has_accepted', null)->where('type','clanRequest');
    }

    public function allSent() {
        return $this->hasMany('App\Request', 'sender', 'id')->where('has_accepted', null)->where('type','friendRequest');
    }
    
    public function friends() {
        $friends_ = $this->belongsToMany('App\User', 'requests', 'sender','receiver')->where('type', 'friendRequest')->where('has_accepted', 'TRUE');
        $friends__ = $this->belongsToMany('App\User', 'requests', 'receiver','sender')->where('type', 'friendRequest')->where('has_accepted', 'TRUE');
        
        $friends = [];
        foreach($friends_->get() as $friend)
            array_push($friends, $friend->id);
        foreach($friends__->get() as $friend)
            array_push($friends, $friend->id);

        return User::select('id', 'name', 'username', 'xp', 'class', 'race', 'gender')
            ->whereIn('id', $friends)
            ->orderBy('xp', 'DESC');
    }

    public function friendIDs() {
        $friends_ = $this->belongsToMany('App\User', 'requests', 'sender','receiver')->where('type', 'friendRequest')->where('has_accepted', 'TRUE');
        $friends__ = $this->belongsToMany('App\User', 'requests', 'receiver','sender')->where('type', 'friendRequest')->where('has_accepted', 'TRUE');
        
        $friends = [];
        foreach($friends_->get() as $friend)
            array_push($friends, $friend->id);
        foreach($friends__->get() as $friend)
            array_push($friends, $friend->id);

        return User::select('id')
            ->whereIn('id', $friends)
            ->orderBy('xp', 'DESC');
    }

    public function friendChatMessages($friendID) {

        $thisMessages = $this->messages($friendID)->get();

        $friend = User::find($friendID);
        $friendMessages = $friend->messages($this->id)->get();
        
        $messages = [];
        foreach($thisMessages as $message)
            array_push($messages, $message->id);
        foreach($friendMessages as $friend)
            array_push($messages, $friend->id);

        return Message::whereIn('id', $messages)
            ->orderBy('date')
            ->get();
    }

    public function ban() {
        return $this->hasOne('App\Blocked', 'user_id');
    }

}
