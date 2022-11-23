<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameReview;
use Illuminate\Http\Request;

class GameReviewSummaryController extends Controller
{
    public function index($id){
       
        $fiveStars=GameReview::where('game_id',$id)->where('stars',5)->count();
        $fourStars=GameReview::where('game_id',$id)->where('stars',4)->count();
        $threeStars=GameReview::where('game_id',$id)->where('stars',3)->count();
        $twoStars=GameReview::where('game_id',$id)->where('stars',2)->count();
        $oneStars=GameReview::where('game_id',$id)->where('stars',1)->count();

        $reviewsCount=GameReview::where('game_id',$id)->count();
        $avgStars=GameReview::where('game_id',$id)->avg('stars'); 
        $firstReview=GameReview::where('game_id',$id)->first();
        return response()->json([
            "fiveStars"=>$fiveStars,
            "fourStars"=>$fourStars,
            "threeStars"=>$threeStars,
            "twoStars"=>$twoStars,
            "oneStars"=>$oneStars,
            "reviewsCount"=>$reviewsCount,
            "firstReview"=>$firstReview,
            "avgStars"=>number_format((float)$avgStars, 2, '.', ''),
        ]);
    } 
}
