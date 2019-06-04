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

    public function blocked() {
        return $this->hasMany('App\Blocked', 'clan', 'id');
    }

    public function owner() {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }

    public function members() {
        return $this->belongsToMany('App\User', 'user_clans', 'clan_id','user_id');
    }

    public function invited() {
        return $this->hasMany('App\Request', 'clan_id', 'id');
    }
}