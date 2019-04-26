<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'comments';

    /**
     * The post this comment belongs to.
     */
    public function post() {
        return $this->belongsTo('App\Post', 'id', 'postID');
    }
}