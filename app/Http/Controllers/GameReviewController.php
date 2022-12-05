<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GameReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('auth:api', array('only' => array('store')));
    }

    public function index($id)
    {
        $per_page=5;
        $reviews=GameReview::where('game_id',$id)->with('user')->orderBy('created_at','desc')->paginate($per_page);
        return $reviews;
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
        if($request->get('image')!=null){
            $img=$request->get('image');
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace('data:image/jpg;base64,', '', $img);

            $img = str_replace(' ', '+', $img);
            $img=base64_decode($img);
            $imageName =date('mdYHis') . uniqid() .'.png';
            Storage::disk('public')->put('reviews/'.$imageName, $img);
            $path="reviews/".$imageName;
            $request->merge(['image'=>$path]);

        }
        $review=GameReview::create([
            'text'=>$request->text,
            'user_id'=>Auth::id(),
            'stars'=>$request->stars,
            'game_id'=>$request->game_id,
            'image'=>isset($request->image) ? $request->image : null,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);

        //Actualizamos el rating del game para el listado

        $game=Game::find($request->game_id);
        
        
        return $review;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GameReview  $gameReview
     * @return \Illuminate\Http\Response
     */
    public function show(GameReview $gameReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GameReview  $gameReview
     * @return \Illuminate\Http\Response
     */
    public function edit(GameReview $gameReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GameReview  $gameReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameReview $gameReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GameReview  $gameReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameReview $gameReview)
    {
        //
    }
}
