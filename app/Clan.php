<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'clans';

    /**
     * The posts this clan has.
     */
    public function posts() {
        return $this->hasMany('App\Post', 'clan_id', 'id');
    }
}