<?php

namespace App\Http\Controllers\API;

use App\Availability;
use App\Booking;
use App\BookingRequest;
use App\User;
use Carbon\Carbon;
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
        $user_count     = User::count();
        $availabilities = $request->availabilities;
        $start          = Carbon::parse($request->date_start);
        $end            = Carbon::parse($request->date_end);

        // Loop through availabilities
        foreach ($availabilities as $availability) {
            $bookingRequest = new BookingRequest();
            $bookingRequest->availability_id    = $availability['id'];
            $bookingRequest->substitute_id      = $availability['user_id'];
            $bookingRequest->user_id            = rand(2, $user_count); //TODO: update with the logged in user
            $bookingRequest->nursery_id         = $request->nursery;
            $bookingRequest->message            = $request->message;
            $bookingRequest->start              = $start;
            $bookingRequest->end                = $end;
            $bookingRequest->save();
        }

        return response()->json([
            'status'            => 'received',
            'start'             => $start,
            'end'               => $end,
            'availabilities'    => $availabilities,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookingRequest  $bookingRequest
     * @return \Illuminate\Http\Response
     */
    public function show(BookingRequest $bookingRequest)
    {
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
        $bookingRequest->delete();

        return response()->json([
            'status'    => 'Booking request deleted',
            'redirect'  => route('booking-requests.index')
        ]);
    }

    public function approve(BookingRequest $bookingRequest)
    {
        $bookingRequest->status = BookingRequest::STATUS_APPROVED;
        $bookingRequest->save();

        // If we have a booking request
        if ($bookingRequest->id) {

            // Create the booking object
            $booking = new Booking();
            $booking->request_id        = $bookingRequest->id;
            $booking->user_id           = $bookingRequest->user->id;
            $booking->substitute_id     = $bookingRequest->substitute->id;
            $booking->nursery_id        = $bookingRequest->nursery->id;
            $booking->start             = $bookingRequest->availability->start;
            $booking->end               = $bookingRequest->availability->end;
            $booking->status            = Booking::STATUS_APPROVED; //TODO: will depends on the process
            $booking->save();

            // Update the availability status
            $availability = $bookingRequest->availability;
            $availability->status = Availability::STATUS_BOOKED;
            $availability->save();
        }

        return response()->json([
            'status'    => 'Booking request approved'
        ]);
    }
}
