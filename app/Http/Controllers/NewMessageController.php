<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\NewMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = NewMessage::where('user_id', Auth::id())->count();
        if ($count > 0) {

            $last_message = NewMessage::where('user_id', Auth::id())->with('chatMessage')->orderBy('id', 'desc')->first();
            if (isset($last_message))
                $last_message->chatMessage->user = User::find($last_message->chatMessage->user_id);
        }
        return response()->json([
            'count' => $count,
            'last_message' => isset($last_message) ? $last_message : null
        ]);
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
     * @param  \App\Models\NewMessage  $newMessage
     * @return \Illuminate\Http\Response
     */
    public function show(NewMessage $newMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewMessage  $newMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(NewMessage $newMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewMessage  $newMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewMessage $newMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewMessage  $newMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy($chat_id)
    {

        $messages = ChatMessage::where('user_id', Auth::id())->where('chat_id', $chat_id)->get();

        foreach ($messages as $message) {
            NewMessage::where('chat_message_id', $message->id)->delete();
            $new_messages = NewMessage::where('chat_id', $chat_id)->where('user_id', '!=', Auth::id())->count();
            if ($new_messages == 0) {
                $message->readed_at = now();
            }
        }

        return response()->json([
            "message" => "Messages readed"
        ]);
    }
}
