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
        return $availabilities; //TODO: check where this is called, must change the return value
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userID = $request->params['userID'];
        $event = $request->params['event'];

        $start = Carbon::parse($event['start']);
        $end = Carbon::parse($event['end']);

        // if no starting hour is passed (thanks momentJS), set it to 8
        if (!$start->hour) {
            $start->hour(8);
            $end->hour($start->hour + 2);
        }

        $availability = new Availability();
        $availability->start = $start;
        $availability->end = $end;
        $availability->user_id = $userID;
        $availability->save();

        return response()->json([
            'status' => 'Availability created',
            'id' => $availability->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Availability $availability
     * @return \Illuminate\Http\Response
     */
    public function show(Availability $availability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Availability $availability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Availability $availability)
    {
        $start = Carbon::parse($request->params['start']);
        $end = Carbon::parse($request->params['end']);

        //TODO: add constraint check

        $availability->start = $start;
        $availability->end = $end;
        $availability->save();

        return response('Availability updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Availability $availability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Availability $availability)
    {
        //TODO: return a boolean to do a check on the front side
        if ($availability) {
            $availability->delete();
            return response('Availability destroyed');
        }

        return response('Availability not destroyed');
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
                'id' => $availability->id,
                'title' => 'Disponible',
                'start' => $availability->start,
                'end' => $availability->end
            ];
        }

        return $availabilities_formatted;
    }

    /**
     * Search for availabilities
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $request)
    {
        global $date_start, $date_end;

        $date_start = null;
        $date_end = null;

        // check if all the inputs are presents
        if ($request->input('day_start') && $request->input('hour_start') && $request->input('hour_end')) {
            // retrieve the starting day
            $day_start = Carbon::parse($request->input('day_start'))->format('d.m.Y');
            // starting hour
            $hour_start = Carbon::parse($request->input('hour_start'), 'Europe/Zurich')->format('H:i');
            // ending hour
            $hour_end = Carbon::parse($request->input('hour_end'), 'Europe/Zurich')->format('H:i');

            // recompose the date object through Carbon, extends the search perimeter for flexibility
            //$date_start = Carbon::parse($day_start . ' ' . $hour_start)->subHour(1);
            //$date_end   = Carbon::parse($day_start . ' ' . $hour_end)->addHour(1);
            $date_start = Carbon::parse($day_start . ' ' . $hour_start);
            $date_end = Carbon::parse($day_start . ' ' . $hour_end);
        }

        // if the search perimeter is correctly defined, proceed
        if ($date_start && $date_end) {

            // availabilities request
            $collection = Availability::where([
                ['start', '<=', $date_start], ['end', '>=', $date_end] // complete
            ])->orWhere([
                ['start', '<=', $date_start], ['end', '<', $date_end], ['end', '>', $date_start] // partial
            ])->orWhere([
                ['start', '>', $date_start], ['end', '>=', $date_end], ['start', '<', $date_end] // partial
            ])->orWhere([
                ['start', '>', $date_start], ['end', '<', $date_end] // partial
            ])->get();

            // determine the matching between the slot and the request
            $collection->each(function ($item, $key) {
                global $date_start, $date_end;

                if ($item->start <= $date_start && $item->end >= $date_end) {
                    $item->matching = 'complete';
                } elseif ($item->start <= $date_start && $item->end < $date_end && $item->end > $date_start) {
                    $item->matching = 'partial';
                } elseif ($item->start > $date_start && $item->end >= $date_end && $item->start < $date_end) {
                    $item->matching = 'partial';
                } elseif ($item->start > $date_start && $item->end < $date_end) {
                    $item->matching = 'partial';
                } else {
                    $item->matching = 'none';
                }
            });

        } else {
            $collection = Availability::all();
        }

        return AvailabilityResource::collection($collection);
    }
}
