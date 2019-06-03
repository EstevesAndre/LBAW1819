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
        'name', 'email', 'password',
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
        return $this->hasMany('App\Post', 'user_id', 'id');
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

    public function friendChatMessages($friendID) {

        $thisMessages = $this->messages($friendID);

        $friend = User::find($friendID);
        $friendMessages = $friend->messages($this->id);

        
        $messages = [];
        foreach($thisMessages->get() as $message)
            array_push($messages, $message->id);
        foreach($friendMessages->get() as $friend)
            array_push($messages, $message->id);

        return Message::select('*')
            ->whereIn('id', $messages)
            ->get();
    }

    public function isBanned() {
        return $this->hasOne('App\Blocked', 'user_id');
    }

}
