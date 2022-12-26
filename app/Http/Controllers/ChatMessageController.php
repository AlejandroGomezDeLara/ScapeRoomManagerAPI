<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatUser;
use App\Models\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use NotificationHelper;

class ChatMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($chat_id,Request $request)
    {
        $per_page=isset($request->per_page) ? $request->per_page : 50;
        $messages=ChatMessage::where('chat_id',$chat_id)->with('user')->latest()->take($per_page)->get();
        
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
        if ($request->get('image') != null) {
            $img=$request->get('image');
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace('data:image/jpg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img=base64_decode($img);
            $imageName =date('mdYHis') . uniqid() .'.png';
            Storage::disk('local')->put('chats/'.$imageName, $img);
            $path="chats/".$imageName;
            $request->merge(['image'=>$path]);  
        }
        $message=ChatMessage::create([
            'chat_id'=>$chat_id,
            'image'=>$request->image ? $request->image : null,
            'user_id'=>Auth::id(),
            'text'=>$request->text,
            'created_at'=>now()
        ]);

        //Mandamos la notificacion push a los usuarios

        if(isset($message)){

            $users=ChatUser::where('chat_id',$chat_id)->where('user_id','!=',Auth::id())->get();

            $registerTokensAppUsers = $users->pluck('id');

            NotificationHelper::storeAndSendPushNotifications($registerTokensAppUsers,$request->text);
            
            //Creamos los mensajes no vistos
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
