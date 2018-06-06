<?php

namespace App\Http\Controllers\API;

use App\BookingRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'Lol wut';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $availabilities = $request->availabilities;

        return response()->json([
            'status'            => 'received',
            'availabilities'    => $availabilities
        ]);

        /*$bookingRequest = new BookingRequest();
        $bookingRequest->user_id            = $request->params['userID'];
        $bookingRequest->availability_id    = $request->params['availabilityID'];
        $bookingRequest->save();

        return response()->json([
            'status'    => 'Booking Request created',
            'id'        => $bookingRequest->id
        ]);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookingRequest  $bookingRequest
     * @return \Illuminate\Http\Response
     */
    public function show(BookingRequest $bookingRequest)
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
