<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Nursery as NurseryResource;
use App\Nursery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NurseryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NurseryResource::collection(\App\Nursery::all());
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
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function show(Nursery $nursery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nursery $nursery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nursery $nursery)
    {
        //
    }
}
