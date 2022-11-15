<?php

namespace App\Http\Controllers;

use App\Models\game;
use Illuminate\Http\Request;


class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate=6;
        
        if(count($request->all())>0){

            /* Filtros */
            $max_price = $request->max_price;
            $min_price = $request->min_price;
            $max_people = $request->max_people;
            $min_people = $request->min_people;
            $min_duration = $request->min_duration;    
            $max_duration = $request->max_duration;                    
            $categories= preg_split('@,@', $request->selected_categories, -1, PREG_SPLIT_NO_EMPTY);
            $subcategories= preg_split('@,@', $request->selected_subcategories, -1, PREG_SPLIT_NO_EMPTY);

            /* searchbar */

            $selected_name=$request->selected_name;
            $selected_address=$request->selected_address;

            if(!empty($categories) && !empty($subcategories)){
                $games= Game::with('category')->with('user')->with('subcategory')
                ->where('min_price','>=',$min_price)
                ->where('min_price','<=',$max_price)
                ->where('max_duration','>=',$min_duration)
                ->where('max_duration','<=',$max_duration)
                ->where('max_people','>=',$min_people)
                ->where('max_people','<=',$max_people)
                ->whereIn('category_id',$categories)
                ->where('name','like','%'.$selected_name.'%')
                ->where('address','like','%'.$selected_address.'%')
                ->paginate($paginate);

            }else if(!empty($categories)){
                $games= Game::with('category')->with('user')->with('subcategory')
                ->where('min_price','>=',$min_price)
                ->where('min_price','<=',$max_price)
                ->where('max_duration','>=',$min_duration)
                ->where('max_duration','<=',$max_duration)
                ->where('max_people','>=',$min_people)
                ->where('max_people','<=',$max_people)
                ->whereIn('category_id',$categories)
                ->where('name','like','%'.$selected_name.'%')
                ->where('address','like','%'.$selected_address.'%')
                ->paginate($paginate);

            }else if(!empty($subcategories)){
                $games= Game::with('category')->with('user')->with('subcategory')
                ->where('min_price','>=',$min_price)
                ->where('min_price','<=',$max_price)
                ->where('max_duration','>=',$min_duration)
                ->where('max_people','>=',$min_people)
                ->where('max_duration','<=',$max_duration)
                ->where('max_people','<=',$max_people)
                ->whereIn('subcategory_id',$subcategories)
                ->where('name','like','%'.$selected_name.'%')
                ->where('address','like','%'.$selected_address.'%')
                ->paginate($paginate);
            }else{
                $games= Game::with('category')->with('user')->with('subcategory')
                ->where('min_price','>=',$min_price)
                ->where('min_price','<=',$max_price)
                ->where('max_duration','>=',$min_duration)
                ->where('max_duration','<=',$max_duration)

                ->where('max_people','>=',$min_people)
                ->where('max_people','<=',$max_people)
                ->where('name','like','%'.$selected_name.'%')
                ->where('address','like','%'.$selected_address.'%')
                ->paginate($paginate);
            }
            
            return $games;

        }else{
            return Game::with('category')->with('user')->with('subcategory')->get();
        }

       
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
     * @param  \App\Models\game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(game $game)
    {
        //
    }
}
