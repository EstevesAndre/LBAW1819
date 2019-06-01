<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'messages';

    /**
     * The receiver of te message
     */
    public function sender($userID) {
        return $this->belongsTo('App\User', 'sender', 'id')->where('receiver', $userID);
    }

    /**
     * The receiver of te message
     */
    public function receiver($userID) {
        return $this->belongsTo('App\User', 'receiver', 'id')->where('sender', $userID);
    }

    public function user() {
        return $this->belongsTo('App\User', 'sender', 'id');
    }
}