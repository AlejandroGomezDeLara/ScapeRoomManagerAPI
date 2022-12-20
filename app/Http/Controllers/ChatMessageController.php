<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatUser;
use App\Models\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($chat_id)
    {
        $messages=ChatMessage::where('chat_id',$chat_id)->with('user')->get();

        return response() -> json($messages, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
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
    public function store($chat_id,Request $request)
    {
        $message=ChatMessage::create([
            'chat_id'=>$chat_id,
            'user_id'=>Auth::id(),
            'text'=>$request->text,
            'created_at'=>now()
        ]);
        if(isset($message)){
            //Creamos los mensajes no vistos
            $users=ChatUser::where('chat_id',$chat_id)->get();
            foreach ($users as $user) {
                NewMessage::create([
                    'user_id'=>$user->user_id,
                    'chat_id'=>$chat_id,
                    'chat_message_id'=>$message->id
                ]);
            }
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatMessage  $chatMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatMessage  $chatMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatMessage  $chatMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatMessage  $chatMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatMessage $chatMessage)
    {
        //
    }
}
