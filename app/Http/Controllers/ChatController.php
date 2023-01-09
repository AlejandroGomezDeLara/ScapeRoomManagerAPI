<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatUser;
use App\Models\NewMessage;
use App\Models\OpenReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $chatUsers = ChatUser::where('user_id', Auth::id())->get();
        $chats = [];
        foreach ($chatUsers as $user) {
            $chat = Chat::with('users')->find($user->chat_id);
            $open_reservation = OpenReservation::with('gameReservationHour')->find($chat->open_reservation_id);
            $chat->open_reservation = $open_reservation;
            $chat->unread_messages_count = NewMessage::where('user_id', Auth::id())->where('chat_id', $chat->id)->count();
            $last_message = ChatMessage::where('chat_id', $user->chat_id)->with('user')->orderBy('created_at', 'desc')->first();
            $chat->last_message = $last_message;
            $chats[] = $chat;
        }
        return $chats;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($chat_id)
    {

        $chat = Chat::with('users')->find($chat_id);
        $open_reservation = OpenReservation::with('gameReservationHour')->find($chat->open_reservation_id);
        $chat->open_reservation = $open_reservation;
        $chat->unread_messages_count = NewMessage::where('user_id', Auth::id())->where('chat_id', $chat->id)->count();
        return $chat;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
