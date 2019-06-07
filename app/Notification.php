<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'notifications';
   
    public function userLiked() {
        return $this->belongsTo('App\User', 'like_user_id', 'id');
    }

    public function userShared() {
        return $this->belongsTo('App\User', 'share_user_id', 'id');
    }
}
