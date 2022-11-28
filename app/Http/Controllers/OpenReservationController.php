<?php

namespace App\Http\Controllers;

use App\Models\GameReview;
use App\Models\OpenReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OpenReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $max_price = $request->max_price;
        $min_price = $request->min_price;
        $max_people = $request->max_people;
        $min_people = $request->min_people;
        $min_duration = $request->min_duration;
        $max_duration = $request->max_duration;
        $categories = preg_split('@,@', $request->selected_categories, -1, PREG_SPLIT_NO_EMPTY);
        $subcategories = preg_split('@,@', $request->selected_subcategories, -1, PREG_SPLIT_NO_EMPTY);

        /* searchbar */

        $selected_name = $request->selected_name;
        $selected_address = $request->selected_address;

        if (!empty($categories) && !empty($subcategories)) {
            $openReservations = OpenReservation::with('users')
                ->with('game')
                ->with('gameCategory')
                ->with('gameSubcategory')
                ->with('gameReservationHour')
                ->where('price_per_user', '>=', $min_price)
                ->where('price_per_user', '<=', $max_price)
                ->whereIn('game_category_id', $categories)
                ->whereIn('game_subcategory_id', $subcategories)
                ->whereDate('date', Carbon::today())
                ->orderBy('date','asc')
                ->whereRaw('actual_people < max_people')
                ->where('completed',0)
                ->whereHas('game', function ($q) use ($min_duration, $max_duration, $min_people, $max_people, $selected_address, $selected_name) {
                    $q->where('max_duration', '>=', $min_duration)
                        ->where('max_duration', '<=', $max_duration)
                        ->where('max_people', '>=', $min_people)
                        ->where('max_people', '<=', $max_people)
                        ->where('name', 'like', '%' . $selected_name . '%')
                        ->where('address', 'like', '%' . $selected_address . '%');
                })
                ->get();
        } else if (!empty($categories)) {
            $openReservations = OpenReservation::with('users')
                ->with('game')
                ->with('gameCategory')
                ->with('gameSubcategory')
                ->with('gameReservationHour')
                ->whereIn('game_category_id', $categories)
                ->where('price_per_user', '>=', $min_price)
                ->where('price_per_user', '<=', $max_price)
                ->whereDate('date', Carbon::today())
                ->orderBy('date','desc')
                ->whereRaw('actual_people < max_people')
                ->where('completed',0)
                ->whereHas('game', function ($q) use ($min_duration, $max_duration, $min_people, $max_people, $selected_address, $selected_name) {
                    $q->where('max_duration', '>=', $min_duration)
                        ->where('max_duration', '<=', $max_duration)
                        ->where('max_people', '>=', $min_people)
                        ->where('max_people', '<=', $max_people)
                        ->where('name', 'like', '%' . $selected_name . '%')
                        ->where('address', 'like', '%' . $selected_address . '%');
                })
                ->get();
        } else if (!empty($subcategories)) {
            $openReservations = OpenReservation::with('users')
                ->with('game')
                ->with('gameCategory')
                ->with('gameSubcategory')
                ->with('gameReservationHour')
                ->where('price_per_user', '>=', $min_price)
                ->where('price_per_user', '<=', $max_price)
                ->whereIn('game_subcategory_id', $subcategories)
                ->whereDate('date', Carbon::today())
                ->orderBy('date','desc')
                ->whereRaw('actual_people < max_people')
                ->where('completed',0)
                ->whereHas('game', function ($q) use ($min_duration, $max_duration, $min_people, $max_people, $selected_address, $selected_name) {
                    $q->where('max_duration', '>=', $min_duration)
                        ->where('max_duration', '<=', $max_duration)
                        ->where('max_people', '>=', $min_people)
                        ->where('max_people', '<=', $max_people)
                        ->where('name', 'like', '%' . $selected_name . '%')
                        ->where('address', 'like', '%' . $selected_address . '%');
                })
                ->get();
        } else {
            $openReservations = OpenReservation::with('users')
                ->with('game')
                ->with('gameCategory')
                ->with('gameSubcategory')
                ->with('gameReservationHour')
                ->where('price_per_user', '>=', $min_price)
                ->where('price_per_user', '<=', $max_price)
                ->whereDate('date', Carbon::today())
                ->orderBy('date','desc')
                ->whereRaw('actual_people < max_people')
                ->where('completed',0)
                ->whereHas('game', function ($q) use ($min_duration, $max_duration, $min_people, $max_people, $selected_address, $selected_name) {
                    $q->where('max_duration', '>=', $min_duration)
                        ->where('max_duration', '<=', $max_duration)
                        ->where('max_people', '>=', $min_people)
                        ->where('max_people', '<=', $max_people)
                        ->where('name', 'like', '%' . $selected_name . '%')
                        ->where('address', 'like', '%' . $selected_address . '%');
                })
                
                ->get();
        }
        foreach($openReservations as $reservation){
            $avgStars=GameReview::where('game_id',$reservation->game["id"])->avg('stars'); 
            $reservation->game->rating=number_format((float)$avgStars, 2, '.', '');
        }
        return $openReservations;
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
     * @param  \App\Models\OpenReservation  $openReservation
     * @return \Illuminate\Http\Response
     */
    public function show(OpenReservation $openReservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpenReservation  $openReservation
     * @return \Illuminate\Http\Response
     */
    public function edit(OpenReservation $openReservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OpenReservation  $openReservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpenReservation $openReservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpenReservation  $openReservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(OpenReservation $openReservation)
    {
        //
    }
}
