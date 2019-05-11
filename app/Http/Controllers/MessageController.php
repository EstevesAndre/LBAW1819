<?php

namespace App\Http\Controllers;

use App\Message;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function create(Request $request, $id) 
    {
        $message = new Message();
        $message->receiver = $id;
        $message->sender = Auth::user()->id;
        $message->message_text =  $request->input('message');
        $message->save();
        $message->date = DB::select('SELECT "date"
                                     FROM messages
                                     ORDER BY "date" desc
                                     LIMIT 1')[0];

        return $message;
    }

    public function update(Request $request, $id){

        $messages = DB::select('SELECT sender,receiver,"date",message_text
                                         FROM messages
                                         WHERE (receiver = :FID AND sender = :ID) OR
                                               (receiver = :ID AND sender = :FID) 
                                         ORDER BY "date"', ['ID' => Auth::user()->id, 'FID' => $id]);

        $friend_info = DB::select('SELECT id, username, name
                                   FROM "users"
                                   WHERE "users".id = :ID',['ID' => $id]);

        return ['friend_info' => $friend_info, 'messages' => $messages];

    }
}
