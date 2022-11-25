<?php

namespace App\Http\Controllers;

use App\Models\OpenReservation;
use Carbon\Carbon;

class GameOpenReservationController extends Controller
{
    public function index($game_id){
        return OpenReservation::with('users')
        ->with('game')
        ->with('gameCategory')
        ->with('gameSubcategory')
        ->whereDate('date', Carbon::today())
        ->where('game_id',$game_id)
        ->orderBy('date','asc')
        ->get();
    }
}
