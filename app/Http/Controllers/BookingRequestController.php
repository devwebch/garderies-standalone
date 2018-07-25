<?php

namespace App\Http\Controllers;

use App\BookingRequest;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookingRequests = BookingRequest::with('user')
            ->where('start', '>=', now())
            ->orderBy('start')
            ->orderBy('status')
            ->with('availability')
            ->get();
        return view('booking-request.index', ['bookingRequests' => $bookingRequests]);
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
     * @param  \App\BookingRequest  $bookingRequest
     * @return \Illuminate\Http\Response
     */
    public function show(BookingRequest $bookingRequest)
    {
        /**
         * Calculate the difference between the original booking request and the availability
         */
        $request_start          = $bookingRequest->start;
        $request_end            = $bookingRequest->end;
        $availability_start     = $bookingRequest->availability->start;
        $availability_end       = $bookingRequest->availability->end;

        // Durations
        $booking_duration       = $request_start->diffInMinutes($request_end);
        $availability_duration  = $availability_start->diffInMinutes($availability_end);

        // Differences between starting and ending hours
        $booking_delay_start    = ($request_start->lte($availability_start)) ? $request_start->diffInMinutes($availability_start) : 0;
        $booking_delay_end      = ($request_end->gte($availability_end)) ? $request_end->diffInMinutes($availability_end) : 0;

        // Percentages calculation
        $completion_pct     = ($availability_duration * 100) / $booking_duration;
        $start_delay_pct    = ($booking_delay_start * 100) / $booking_duration;
        $end_delay_pct      = ($booking_delay_end * 100) / $booking_duration;

        /**
         * Check for conflicts
         */
        $conflict_start = $bookingRequest->start->lt($bookingRequest->availability->start);
        $conflict_end   = $bookingRequest->end->gt($bookingRequest->availability->end);

        $availability   = $bookingRequest->availability;

        return view('booking-request.show', [
            'bookingRequest'    => $bookingRequest,
            'availability'      => $availability,
            'conflict_start'    => $conflict_start,
            'conflict_end'      => $conflict_end,
            'completion_pct'    => $completion_pct,
            'start_pct'         => $start_delay_pct,
            'end_pct'           => $end_delay_pct,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingRequest  $bookingRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingRequest $bookingRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookingRequest  $bookingRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingRequest $bookingRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingRequest  $bookingRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingRequest $bookingRequest)
    {
        //
    }
}
