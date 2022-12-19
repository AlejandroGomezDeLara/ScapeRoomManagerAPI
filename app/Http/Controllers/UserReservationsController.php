<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameReview;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReservationsController extends Controller
{
    public function index(){
       $reservations=Reservation::where('user_id',Auth::id())
       ->with('gameReservationHour')
       ->with('gamePrice')->get();
        
       foreach($reservations as $reservation){
            $game=Game::with('category')->find($reservation->game_id);
            $reviewsCount=GameReview::where('game_id',$reservation->game_id)->count();
            $avgStars=GameReview::where('game_id',$reservation->game_id)->avg('stars'); 
            $game->reviewsCount=$reviewsCount;
            $game->rating=number_format((float)$avgStars, 2, '.', '');
            $reservation->game=$game;
       }
       return $reservations;
    }
}
