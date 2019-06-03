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
        return $this->belongsTo('App\Clan', 'id', 'clan');
    }
}