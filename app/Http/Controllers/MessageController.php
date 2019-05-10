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
}
