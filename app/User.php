<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The posts this user owns.
     */
    public function posts() {
        return $this->hasMany('App\Post', 'user_id', 'id');
    }

    public function likes() {
        return $this->hasMany('App\Like', 'id', 'user_id');   
    }

    public static function getUserFriends($id) {
        $friendsQuery = DB::select('SELECT DISTINCT u2.id
                                FROM "users" u1 INNER JOIN requests ON (requests.type = \'friendRequest\' AND (u1.id = requests.sender OR u1.id = requests.receiver)), "users" u2
                                WHERE u1.id = :ID
                                    AND requests.has_accepted = TRUE
                                    AND (   (requests.receiver = u2.id AND requests.receiver !=  u1.id)
                                            OR
                                            (requests.sender = u2.id AND requests.sender != u1.id)
                                )', ['ID' => $id]);
        $friendsIDs = array();
        foreach($friendsQuery as $aux) 
            $friendsIDs[] = $aux->id;

        return User::select('id', 'name', 'username', 'xp', 'class', 'race', 'gender')
            ->whereIn('id', $friendsIDs)
            ->orderBy('xp', 'DESC')
            ->get();
    }
}
