<?php

namespace App\Http\Controllers\API;

use App\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
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
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function showForUser(\App\User $user, Request $request)
    {
        // Retrieve user availabilities, constrains to start and end paramaters passed from fullcalendar
        $bookings = $user->bookings()
            ->where('start', '>=', $request->start)
            ->where('end', '<=', $request->end)
            ->get();

        // New array for formatted data
        $bookings_formatted = [];

        // Loop through each object
        foreach ($bookings as $booking) {

            // See fullcalendar doc for format
            $bookings_formatted[] = [
                'id'        => 'b_' . $booking->id,
                'title'     => 'En remplacement',
                'start'     => $booking->start,
                'end'       => $booking->end
            ];
        }

        return $bookings_formatted;
    }
}
