<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
  // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'likes';

    /**
     * The post this like belongs to.
     */
    public function post() {
        return $this->belongsTo('App\Post', 'id', 'post_id');
    }
}