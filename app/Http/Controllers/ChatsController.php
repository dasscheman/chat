<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\PrivateMessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }

    public function private($id)
    {
        $toUser = User::findOrFail($id);
        return view('private', compact('toUser'));
    }

    public function fetchMessages()
    {
        return Message::with('user')
          	->whereNull('to')
            ->get();
    }

    public function fetchAllUsers()
    {
        // $startedConversations = Message::select('to')
        //     ->distinct()
        //     ->where('user_id', auth()->user()->id)
        //     ->whereNotNull('to')
        //     ->pluck('to')->toArray();
        // $receivedConversations = Message::select('user_id')
        //     ->distinct()
        //     ->where('user_id', '!=', auth()->user()->id)
        //     ->where('to', auth()->user()->id)
        //     ->pluck('user_id')->toArray();
        // $users = array_unique(array_merge($startedConversations, $receivedConversations));

        // return User::whereIn('id', $users)->get();

        return User::all();
    }

    public function fetchCurrentUser()
    {
        return auth()->user();
    }

    public function sendMessage(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);

	      broadcast(new MessageSent(auth()->user(), $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }


    public function fetchPrivateMessages($toUser)
    {
        $messages = Message::with('user')
            ->where(function($q) use ($toUser){
                $q->where('user_id', $toUser)
                  ->Where('to', auth()->user()->id);
            })

            ->orWhere(function($q) use ($toUser) {
                $q->where('user_id', auth()->user()->id)
                  ->Where('to', $toUser);
            })
            ->orderBy('created_at')
            ->get();
        return $messages;
    }

    public function sendPrivateMessage(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message,
            'to' => $request->to_user
        ]);

        $toUser = User::findOrFail($request->to_user);

	      broadcast(new PrivateMessageSent(auth()->user(), $message, $toUser))->toOthers();

        return ['status' => 'Private Message Sent!'];
    }

}
