<?php

namespace App\Http\Controllers;

use App\Models\DayRequired;
use Illuminate\Http\Request;

class DayRequiredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $dayRequired = new DayRequired();
        $dayRequired->fill($request->all());
        $dayRequired->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DayRequired  $dayRequired
     * @return \Illuminate\Http\Response
     */
    public function show(DayRequired $dayRequired)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DayRequired  $dayRequired
     * @return \Illuminate\Http\Response
     */
    public function edit(DayRequired $dayRequired)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DayRequired  $dayRequired
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DayRequired $dayRequired)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DayRequired  $dayRequired
     * @return \Illuminate\Http\Response
     */
    public function destroy(DayRequired $dayRequired)
    {
        //
    }
}
