<?php

namespace App\Http\Controllers;

use App\Models\CompletedReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompletedReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CompletedReservation::where('user_id',Auth::id())->get();
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
     * @param  \App\Models\CompletedReservation  $completedReservation
     * @return \Illuminate\Http\Response
     */
    public function show(CompletedReservation $completedReservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompletedReservation  $completedReservation
     * @return \Illuminate\Http\Response
     */
    public function edit(CompletedReservation $completedReservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompletedReservation  $completedReservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompletedReservation $completedReservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompletedReservation  $completedReservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompletedReservation $completedReservation)
    {
        //
    }
}
