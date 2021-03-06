<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blocked extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'blockeds';

    /**
     * The posts this clan has.
     */
    public function clan() {
        return $this->belongsTo('App\Clan', 'clan', 'id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function clanUser() {
        return $this->belongsTo('App\User', 'user_id', 'id')->whereNotNull('clan');
    }
}