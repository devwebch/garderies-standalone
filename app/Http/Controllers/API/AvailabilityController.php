<?php

namespace App\Http\Controllers\API;

use App\Availability;
use App\Http\Resources\Availability as AvailabilityResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $availabilities = Availability::all();

        return $availabilities;
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
     * @param  \App\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function show(Availability $availability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Availability $availability)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Availability $availability)
    {
        //
    }

    /**
     * Show availabilities for a specific user
     *
     * @param \App\User $user
     * @param Request $request
     * @return array
     */
    public function showForUser(\App\User $user, Request $request)
    {
        // Retrieve user availabilities, constrains to start and end paramaters passed from fullcalendar
        $availabilities = $user->availabilities()
            ->where('start', '>=', $request->start)
            ->where('end', '<=', $request->end)
            ->get();

        // New array for formatted data
        $availabilities_formatted = [];

        // Loop through each object
        foreach ($availabilities as $availability) {

            // See fullcalendar doc for format
            $availabilities_formatted[] = [
                'id'        => $availability->id,
                'title'     => 'Disponible',
                'start'     => $availability->start,
                'end'       => $availability->end
            ];
        }

        return $availabilities_formatted;
    }

    public function search(Request $request)
    {
        return AvailabilityResource::collection(Availability::all());
    }
}
