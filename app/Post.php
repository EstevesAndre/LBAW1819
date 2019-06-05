<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'posts';
    /**
     * The user this post belongs to
     */
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function clan() {
        return $this->belongsTo('App\Clan', 'clan_id', 'id');
    }

    public function getPost($id) {
        return Post::find($id);
    }

    /**
     * Comments inside this post
     */
    public function comment() {
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }

    /**
     * Likes inside this post
     */
    public function like() {
        return $this->hasMany('App\Like', 'post_id', 'id');
    }

    /**
     * Shares inside this post
     */
    public function share() {
        return $this->hasMany('App\Share', 'post_id', 'id');
    }

    public function sharedByMe($id) {
        return $this->hasOne('App\Share', 'post_id', 'id')->where('user_id', $id);
    }
}
