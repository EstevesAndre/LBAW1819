<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'messages';

    /**
     * The receiver of te message
     */
    public function sender() {
        return $this->belongsTo('App\User', 'sender', 'id');
    }

    /**
     * The receiver of te message
     */
    public function receiver() {
        return $this->belongsTo('App\User', 'receiver', 'id');
    }
}