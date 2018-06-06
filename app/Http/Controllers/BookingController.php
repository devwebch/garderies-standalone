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
        return view('booking.show', ['booking' => $booking]);
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
