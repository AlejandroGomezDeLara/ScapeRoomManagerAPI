<?php

namespace App\Http\Controllers;

use App\Models\OpenReservation;
use App\Models\OpenReservationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOpenReservationController extends Controller
{
    public function index(){
        $user_id=Auth::id();
        $openReservations=[];
        $openReservationsUsers=OpenReservationUser::where('user_id',$user_id)->get();
        
        if(isset($openReservationsUsers)){
            foreach($openReservationsUsers as $reservationUser){
                $openReservations[]=OpenReservation::where('id',$reservationUser->open_reservation_id)
                ->where('completed',0)
                ->with('users')
                ->with('game')
                ->with('gameCategory')
                ->with('gameSubcategory')
                ->with('gameReservationHour')->first();
            }
        }
        
       return $openReservations;
    }
}
