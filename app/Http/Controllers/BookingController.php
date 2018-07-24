<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Nursery;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::where('start', '>=', now())
            ->orderBy('status', 'desc')
            ->orderBy('start')
            ->get();
        $bookings_archive = Booking::where('start', '<', now())
            ->orderBy('start')
            ->get();

        return view('booking.index', [
            'bookings'          => $bookings,
            'bookings_archive'  => $bookings_archive,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users      = User::where('id', '!=', 1)->orderBy('name')->get();
        $nurseries  = Nursery::all();

        return view('booking.create', ['users' => $users, 'nurseries' => $nurseries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = new Booking();
        $booking->user_id       = $request->user;
        $booking->substitute_id = $request->substitute;
        $booking->nursery_id    = $request->nursery;
        $booking->start         = Carbon::parse($request->date_start);
        $booking->end           = Carbon::parse($request->date_end);
        $booking->save();

        return redirect()->route('bookings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $request_start          = $booking->request->start;
        $request_end            = $booking->request->end;
        $availability_start     = $booking->request->availability->start;
        $availability_end       = $booking->request->availability->end;

        $booking_duration       = $request_start->diffInMinutes($request_end);
        $availability_duration  = $availability_start->diffInMinutes($availability_end);

        $booking_delay_start    = ($request_start->lte($availability_start)) ? $request_start->diffInMinutes($availability_start) : 0;
        $booking_delay_end      = ($request_end->gte($availability_end)) ? $request_end->diffInMinutes($availability_end) : 0;

        $completion_pct     = ($availability_duration * 100) / $booking_duration;
        $start_delay_pct    = ($booking_delay_start * 100) / $booking_duration;
        $end_delay_pct      = ($booking_delay_end * 100) / $booking_duration;

        $avatars = ['img/dummy_avatar_1.jpg', 'img/dummy_avatar_2.jpg', 'img/dummy_avatar_3.jpg'];

        return view('booking.show', [
            'booking'           => $booking,
            'completion_pct'    => $completion_pct,
            'start_pct'         => $start_delay_pct,
            'end_pct'           => $end_delay_pct,
            'avatar1'           => $avatars[0],
            'avatar2'           => $avatars[2],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        return view('booking.edit', ['booking' => $booking]);
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
        $start  = Carbon::parse($request->date_start);
        $end    = Carbon::parse($request->date_end);

        $booking->start = $start;
        $booking->end   = $end;
        $booking->save();

        return redirect()->route('bookings.index');
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
}
