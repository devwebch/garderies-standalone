<?php

namespace App\Http\Controllers\API;

use App\Availability;
use App\Http\Resources\Availability as AvailabilityResource;
use Carbon\Carbon;
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
        $userID     = $request->params['userID'];
        $event      = $request->params['event'];

        $availability = new Availability();
        $availability->start    = Carbon::parse($event['start']);
        $availability->end      = Carbon::parse($event['end']);
        $availability->user_id  = $userID;
        $availability->save();

        return response()->json([
            'status'    => 'Availability created',
            'id'        => $availability->id
        ]);
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
        $start  = Carbon::parse($request->params['start']);
        $end    = Carbon::parse($request->params['end']);

        $availability->start = $start;
        $availability->end = $end;
        $availability->save();

        return response('Availability updated');
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
        $date_start = null;
        $date_end = null;
        if ($request->input('date_start') && $request->input('date_end')) {
            $date_start = Carbon::parse($request->input('date_start'));
            $date_end   = Carbon::parse($request->input('date_end'));
        }

        if ($date_start && $date_end) {
            $collection = Availability::where('start', '>=', $date_start)
                ->where('end', '<=', $date_end)
                ->get();
        } else {
            $collection = Availability::all();
        }

        return AvailabilityResource::collection($collection);
    }
}
