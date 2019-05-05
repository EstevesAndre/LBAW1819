<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
  // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'likes';

    protected $primaryKey = ['post_id', 'user_id'];
    public $incrementing = false;

    /**
     * The post this like belongs to.
     */
    public function post() {
        return $this->belongsTo('App\Post', 'post_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}