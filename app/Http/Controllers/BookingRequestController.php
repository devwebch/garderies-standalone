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
        $conflict_start = $bookingRequest->start->lt($bookingRequest->availability->start);
        $conflict_end   = $bookingRequest->end->gt($bookingRequest->availability->end);

        $availability   = $bookingRequest->availability;

        return view('booking-request.show', [
            'bookingRequest'    => $bookingRequest,
            'availability'      => $availability,
            'conflict_start'    => $conflict_start,
            'conflict_end'      => $conflict_end,
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
