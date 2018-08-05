<?php

namespace App\Http\Controllers\API;

use App\Availability;
use App\Http\Controllers\Controller;
use App\Http\Resources\Availability as AvailabilityResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

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
        $user   = User::find($userID);
        $event  = $request->params['event'];
        $default_duration = config('nursery.default_availability_duration');
        
        $start  = Carbon::parse($event['start']);
        $end    = Carbon::parse($event['end']);

        $opening_time = $start->copy()->hour(config('nursery.opening_time'))->minute(0);
        $closing_time = $end->copy()->hour(config('nursery.closing_time'))->minute(0);

        // if no starting hour is passed (thanks momentJS), set it to 8
        if (!$start->hour) {
            $start = $opening_time;
            $end = $start->copy()->addHours($default_duration);
        }

        if ($start->lt($opening_time)) { $start = $opening_time; $end = $start->copy()->addHours($default_duration); }
        if ($start->gte($closing_time)) { $start = $closing_time->copy()->subHours($default_duration); }
        if ($end->gt($closing_time)) { $end = $closing_time; $start = $end->copy()->subHours($default_duration); }

        $availabilities = Availability::whereYear('start', $start->format('Y'))
            ->whereMonth('start', $start->format('m'))
            ->whereDay('start', $start->format('d'))
            ->where('user_id', $userID)
            ->get();

        $isOverlapping  = false;
        $overlapStart   = null;
        $overlapEnd     = null;

        foreach ($availabilities as $availability) {
            if (
                ($start->lte($availability->start) && $end->gte($availability->start) && $end->lte($availability->end)) || // overlapse before
                ($start->gte($availability->start) && $start->lte($availability->end) && $end->gte($availability->end)) || // overlapse after
                ($start->gte($availability->start) && $end->lte($availability->end)) || // between
                ($end->lt($availability->start) && $end->gt($availability->end)) // total overlapse
            ) {
                $isOverlapping = true;
                $overlapStart   = $availability->start; // overlap on start
                $overlapEnd     = $availability->end; // overlap on end
            }
        }

        // set the start and end date depending on the overlap type
        // TODO: determine open slots amongst the availabilities
        if ($isOverlapping) {

            if ($start->lte($overlapStart)) {
                $start  = $overlapStart->copy()->subHours($default_duration);
                $end    = $start->copy()->addHours($default_duration);
            } else {
                $start  = $overlapEnd->copy();
                $end    = $start->copy()->addHours($default_duration);
            }

            if ($start->lt($opening_time) || $end->gt($closing_time)) {
                $nextDay = $start->copy()->addDay(1);
                $freetime = UserController::getAvailableSlots($user, $nextDay);

                $slot_start     = $freetime['slots'][0]['start'];
                $slot_end       = $freetime['slots'][0]['end'];
                $start  = $slot_start;
                $end    = $slot_start->copy()->addHours($default_duration);
                if ($end->gt($slot_end)) { $end = $slot_end; }
            }

            // if the new availability ends up on a weekend, adjust day
            if ($start->isSaturday()) { $start->addDay(2); $end->addDay(2); }
            if ($start->isSunday()) { $start->addDay(1); $end->addDay(1); }

            $isOverlapping = false;
        }

        $availability = null;
        if (!$isOverlapping) {
            $availability = new Availability();
            $availability->start    = $start;
            $availability->end      = $end;
            $availability->user_id  = $userID;
            $availability->save();
        }

        return response()->json([
            'status'        => 'Availability created',
            'isOverlapping' => $isOverlapping,
            'event'         => $availability,
            'id'            => isset($availability) ? $availability->id : null
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
        
        $colors = ['#3a87ad', '#607d8b', '#fbc02d', '#666666'];
        
        // Loop through each object
        foreach ($availabilities as $availability) {
            
            // See fullcalendar doc for format
            $availabilities_formatted[] = [
                'id'        => $availability->id,
                'title'     => 'Disponible',
                'start'     => $availability->start->toDateTimeString(),
                'end'       => $availability->end->toDateTimeString(),
                'status'    => $availability->status,
                'color'     => $colors[$availability->status],
                'rendering' => ($availability->status == Availability::STATUS_UNTOUCHED) ? '' : 'background',
                'type'      => 'availability'
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

        $ext_search     = ($request->input('extended') == 'true') ? true : false ;
        $date_start     = null;
        $date_end       = null;
        
        // check if all the inputs are presents
        if ($request->input('day_start') && $request->input('hour_start') && $request->input('hour_end')) {
            // retrieve the starting day
            $day_start = Carbon::parse($request->input('day_start'))->format('d.m.Y');
            // starting hour
            $hour_start = Carbon::parse($request->input('hour_start'), 'Europe/Zurich')->format('H:i');
            // ending hour
            $hour_end = Carbon::parse($request->input('hour_end'), 'Europe/Zurich')->format('H:i');
            
            // recompose the date object through Carbon
            $date_start = Carbon::parse($day_start . ' ' . $hour_start);
            $date_end = Carbon::parse($day_start . ' ' . $hour_end);
        }
        
        // if the search perimeter is correctly defined, proceed
        if ($date_start && $date_end) {

            $date_start_extended    = $date_start->copy()->addMinutes(30);
            $date_end_extended      = $date_end->copy()->subMinutes(30);
            
            // availabilities request
            if (!$ext_search) {
                $collection = Availability::where([
                    ['start', '<=', $date_start_extended],
                    ['end', '>=', $date_end_extended],
                    ['status', '!=', Availability::STATUS_ARCHIVED],
                    ['status', '!=', Availability::STATUS_BOOKED]// complete
                ])
                ->orderBy('start')
                ->get();
            } else {
                $collection = Availability::where([
                    ['start', '<=', $date_start],
                    ['end', '>=', $date_end],
                    ['status', '!=', Availability::STATUS_ARCHIVED],
                    ['status', '!=', Availability::STATUS_BOOKED]// complete
                ])->orWhere([
                    ['start', '<=', $date_start],
                    ['end', '<', $date_end],
                    ['end', '>', $date_start],
                    ['status', '!=', Availability::STATUS_ARCHIVED],
                    ['status', '!=', Availability::STATUS_BOOKED]// partial
                ])->orWhere([
                    ['start', '>', $date_start],
                    ['end', '>=', $date_end],
                    ['start', '<', $date_end],
                    ['status', '!=', Availability::STATUS_ARCHIVED],
                    ['status', '!=', Availability::STATUS_BOOKED]// partial
                ])->orWhere([
                    ['start', '>', $date_start],
                    ['end', '<', $date_end],
                    ['status', '!=', Availability::STATUS_ARCHIVED],
                    ['status', '!=', Availability::STATUS_BOOKED]// partial
                ])
                ->orderBy('start')
                ->get();
            }

            // determine the matching between the slot and the request
            $collection->each(function ($item, $key) {
                global $collection, $date_start, $date_end;
                
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

        $collection = $collection->sortBy('matching');

        return AvailabilityResource::collection($collection);
    }

    /**
     * Look through booking related to an availability
     * to determine the available slots
     *
     * @param Availability $availability
     * @return array
     */
    public function getAvailableBookingSlots(Availability $availability)
    {
        // get related bookings
        $bookings   = $availability->bookings()->orderBy('start')->get();

        // init
        $start      = $availability->start->copy();
        $busy_min   = 0;
        $slots      = [];

        // loop through the associated bookings
        foreach ($bookings as $key => $booking) {

            // store each booking duration
            if ($booking->start->lt($availability->start)) {
                $busy_min += $booking->end->diffInMinutes($availability->start);
            } elseif ($booking->end->gt($availability->end)) {
                $busy_min += $booking->start->diffInMinutes($availability->end);
            } else {
                $busy_min += $booking->start->diffInMinutes($booking->end);
            }

            // If this is the last booking and it is exactly the same length, exit early
            if ($key == $bookings->count() &&
                $booking->start->equaltTo($availability->start) &&
                $booking->end->equaltTo($availability->end)
            ) {
                break;
            }

            // register available slots
            if ($booking->start->equalTo($start)) {
                $start->addMinutes($booking->start->diffInMinutes($booking->end));
            } else {
                $slot_start = $start->copy();
                $slot_end   = $start->copy()->addMinutes($start->diffInMinutes($booking->start));
                $start      = $booking->end;

                $slots[] = ['start' => $slot_start, 'end' => $slot_end];
            }

            // if the last booking ends before the availability, retrieve the ending slot
            if ($key == $bookings->count() - 1 && $booking->end->lt($availability->end)) {
                $slot_start = $booking->end->copy();
                $slot_end   = $slot_start->copy()->addMinutes($booking->end->diffInMinutes($availability->end));

                $slots[] = ['start' => $slot_start, 'end' => $slot_end];
            }
        }

        // prep return data
        $data = [
            'availability_duration' => $availability->start->diffInMinutes($availability->end),
            'bookings_duration'     => $busy_min,
            'slots'                 => $slots
        ];

        return $data;
    }

}
