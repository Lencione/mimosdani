<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('message.index');
    }

    public function getAll()
    {
        return Message::orderBy('id', 'desc')->paginate();
    }

    public function get($id)
    {
        $message = Message::find($id);
        $message->status = 'read';
        $message->save();
        return $message;   
    }
}
