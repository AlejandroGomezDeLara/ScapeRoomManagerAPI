<?php

namespace App\Http\Controllers;

use App\Models\GameSubcategory;
use Illuminate\Http\Request;

class GameSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GameSubcategory::all();
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
     * @param  \App\Models\GameSubcategory  $gameSubcategory
     * @return \Illuminate\Http\Response
     */
    public function show(GameSubcategory $gameSubcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GameSubcategory  $gameSubcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(GameSubcategory $gameSubcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GameSubcategory  $gameSubcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameSubcategory $gameSubcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GameSubcategory  $gameSubcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameSubcategory $gameSubcategory)
    {
        //
    }
}
