<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\MessageSend;
use App\Events\SingleChat;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
class ChatController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('unSeenChats')->get();
       
        return view('admin.chat', [
            'users' => $users
        ]);
    }

    public function messageReceived(Request $request){

        $request->validate([
            'message' => 'required',
            'receiverId' => 'required|exists:users,id',
            'senderId' => 'required|exists:users,id',
        ]);
        $receiver = User::findOrFail($request->receiverId);
        $sender = User::findOrFail($request->senderId);
        $chat = Chat::create([
            "message" => $request->message,
            "receiver_id" => $request->receiverId,
            "sender_id" => $request->senderId,
        ]);

        broadcast(new SingleChat($sender, $receiver, $request->message));
        return response()->json('success');
    }

    public function singleChat(Request $request,User $user){

        $chats = Chat::where([
            ['receiver_id', '=', $user->id],
            ['sender_id', '=', auth()->user()->id],
        ])
        ->orWhere([
            ['sender_id', '=', $user->id],
            ['receiver_id', '=', auth()->user()->id],
        ])->get();

        Chat::where([
            ['sender_id', '=', $user->id],
            ['receiver_id', '=', auth()->user()->id],
        ])->update(['seen' => true]);
        $data = [
            'user' => $user,
            'chats' => $chats->toArray(),
        ];

        return response()->json($data, 200);
    }
}
