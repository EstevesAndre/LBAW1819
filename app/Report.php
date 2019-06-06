<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'reports';
   

    /**
     * The receiver of te request
     */
    public function sender() {
        return $this->belongsTo('App\User', 'sender', 'id');
    }

    /**
     * The receiver of the request
     */

    public function post() {
        return $this->belongsTo('App\Post', 'post_id', 'id');
    }   
}
