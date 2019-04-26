<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'shares';

    /**
     * The post this share belongs to.
     */
    public function post() {
        return $this->belongsTo('App\Post', 'id', 'postID');
    }
}