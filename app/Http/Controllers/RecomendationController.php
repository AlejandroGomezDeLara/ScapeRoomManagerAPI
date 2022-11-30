<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameReview;
use Illuminate\Http\Request;

class RecomendationController extends Controller
{
    public function index()
    {
        $games = Game::with('category')->with('user')->with('subcategory')
            ->limit(3)->get()->toArray();
            
        foreach ($games as $game) {
            $reviewsCount = GameReview::where('game_id', $game["id"])->count();
            $avgStars = GameReview::where('game_id', $game["id"])->avg('stars');
            $firstReview = GameReview::where('game_id', $game["id"])->with('user')->orderBy('stars', 'desc')->orderBy('created_at', 'desc')->first();
            $game["reviewsCount"] = $reviewsCount;
            $game["rating"] = number_format((float)$avgStars, 2, '.', '');
            $game["firstReview"] = $firstReview;
        }
        usort($games,function($first,$second){
            return $first["rating"] < $second["rating"];
        });

        return $games;
    }
  
}
