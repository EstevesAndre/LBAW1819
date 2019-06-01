<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'requests';
   

    /**
     * The receiver of te request
     */
    public function sender() {
        return $this->belongsTo('App\User', 'sender', 'id');
    }

    /**
     * The receiver of te request
     */
    public function receiver() {
        return $this->belongsTo('App\User', 'receiver', 'id');
    }

    public function type() {
        return $this->type;
    }

    

}
