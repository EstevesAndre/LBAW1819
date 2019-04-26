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
        return $this->belongsTo('App\User');
    }

    public function getPost($id) {
        return Post::find($id);
    }

    /**
     * Comments inside this post
     */
    public function comment() {
        return $this->hasMany('App\Comment', 'postID', 'id');
    }

    /**
     * Likes inside this post
     */
    public function like() {
        return $this->hasMany('App\Like', 'postID', 'id');
    }

    /**
     * Shares inside this post
     */
    public function share() {
        return $this->hasMany('App\Share', 'postID', 'id');
    }
}
