<?php

namespace App\Http\Controllers;

use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GameCategory::with('images')->get();
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
     * @param  \App\Models\GameCategory  $gameCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return GameCategory::with('images')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GameCategory  $gameCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(GameCategory $gameCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GameCategory  $gameCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameCategory $gameCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GameCategory  $gameCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameCategory $gameCategory)
    {
        //
    }
}
