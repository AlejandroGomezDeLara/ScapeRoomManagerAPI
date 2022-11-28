<?php

namespace App\Http\Controllers;

use App\Models\GameReservationHour;
use App\Models\OpenReservation;
use App\Models\Reservation;
use Illuminate\Http\Request;

class GameReservationHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($game_id)
    {
        $hours = GameReservationHour::where('game_id', $game_id)->get();

        foreach ($hours as $hour) {
            $hour->reservation = Reservation::where('game_reservation_hour_id', $hour["id"])
                ->where('completed', '=', 0)->get();
            $hour->open_reservation = OpenReservation::where('game_reservation_hour_id', $hour["id"])
                ->where('completed', '=', 0)->get();
        }
        return $hours;
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
     * @param  \App\Models\GameReservationHour  $gameReservationHour
     * @return \Illuminate\Http\Response
     */
    public function show(GameReservationHour $gameReservationHour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GameReservationHour  $gameReservationHour
     * @return \Illuminate\Http\Response
     */
    public function edit(GameReservationHour $gameReservationHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GameReservationHour  $gameReservationHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameReservationHour $gameReservationHour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GameReservationHour  $gameReservationHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameReservationHour $gameReservationHour)
    {
        //
    }
}
