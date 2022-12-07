<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Game;
use App\Models\GameReview;
use App\Models\OpenReservation;
use App\Models\OpenReservationUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                ->whereDate('date', '>=', Carbon::now('GMT+1'))
                ->orderBy('date', 'asc')
                ->whereRaw('actual_people < max_people')
                ->where('completed', 0)
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
                ->whereDate('date', '>=', Carbon::now('GMT+1'))
                ->orderBy('date', 'desc')
                ->whereRaw('actual_people < max_people')
                ->where('completed', 0)
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
                ->whereDate('date', '>=', Carbon::now('GMT+1'))
                ->orderBy('date', 'desc')
                ->whereRaw('actual_people < max_people')
                ->where('completed', 0)
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
                ->whereDate('date', '>=', Carbon::now('GMT+1'))
                ->orderBy('date', 'desc')
                ->whereRaw('actual_people < max_people')
                ->where('completed', 0)
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
        foreach ($openReservations as $reservation) {
            $avgStars = GameReview::where('game_id', $reservation->game["id"])->avg('stars');
            $reservation->game->rating = number_format((float)$avgStars, 2, '.', '');
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
        $openReservationId = $request->id;
        if (!isset($openReservationId)) {
            $game = Game::find($request->game_id);

            $openReservation = OpenReservation::create([
                'game_id' => $game["id"],
                'game_category_id' => $game["category_id"],
                'game_subcategory_id' => $game["subcategory_id"],
                'max_people' => $game["max_people"],
                'min_people' => $game["min_people"],
                'actual_people' => 1,
                'date' => Carbon::parse($request->date),
                'price_per_user' => $game["min_price"],
                'closed' => 0,
                'paid' => 0,
                'confirmed' => 0,
                'completed' => 0,
                'game_reservation_hour_id' => $request->game_reservation_hour["id"],
                'created_at' => now(),
                'updated_at' => now()

            ]);

            OpenReservationUser::create([
                'open_reservation_id' => $openReservation->id,
                'user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $chat = Chat::create([
                'name' => 'Reserva ' . $game["name"],
                'open_reservation_id' => $openReservation->id,
                'image' => $game["image"] ? $game["image"] : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);


            ChatUser::create([
                'user_id' => Auth::id(),
                'chat_id' => $chat->id
            ]);

            

            return response()->json([
                'message' => 'Reserva creada correctamente',
                'reservation' => $openReservation
            ]);
        } else {


            $openReservation = OpenReservation::find($openReservationId);
            $people = OpenReservationUser::where('open_reservation_id', $openReservationId)->count();

            if ($people < $openReservation->max_people) {
                $reservationUser = OpenReservationUser::where('user_id', Auth::id())->where('open_reservation_id', $openReservationId)->first();

                if (!isset($reservationUser)) {

                    $added = OpenReservationUser::create([
                        'open_reservation_id' => $openReservationId,
                        'user_id' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    if ($added) {

                        $people = OpenReservationUser::where('open_reservation_id', $openReservationId)->count();

                        OpenReservation::where('id', $openReservationId)->update([
                            'actual_people' => $people
                        ]);

                        $chat = Chat::where('open_reservation_id', $openReservation->id)->first();

                        ChatUser::create([
                            'user_id' => Auth::id(),
                            'chat_id' => $chat->id
                        ]);

                        if ($people == $openReservation->max_people) {
                            OpenReservation::where('id', $openReservationId)->update([
                                'closed' => 1
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'error' => 'Ya estás añadido a esa reserva'
                    ], 500);
                }


                return response()->json([
                    'message' => 'Unido correctamente a la reserva'
                ]);
            } else {
                return response()->json([
                    'error' => 'La reserva ya está llena'
                ], 500);
            }
        }
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
