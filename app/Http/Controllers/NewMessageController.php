<?php

namespace App\Http\Controllers;

use App\Models\NewMessage;
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
        $count=NewMessage::where('user_id',Auth::id())->count();
        
        return $count;
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
    public function destroy(NewMessage $newMessage)
    {
        //
    }
}
