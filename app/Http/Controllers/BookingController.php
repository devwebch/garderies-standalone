<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingRequest;
use App\Http\Resources\Availability;
use App\Nursery;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        Validator::make($request->all(), [
            'user' => 'required',
            'substitute' => 'required|not_in:' . $request->user,
            'nursery' => 'required',
            'date_start' => 'required|date|after:yesterday',
            'date_end' => 'required|date|after:date_start',
        ], [
            'user.required' => 'Veuillez séleccionner un employé.',
            'substitute.required' => 'Veuillez séleccionner un remplaçant.',
            'substitute.not_in' => 'Veuillez séleccionner un remplaçant différent de l\'employé.',
            'nursery.required' => 'Veuillez séleccionner une garderie.',
            'date_start.required' => 'Veuillez séleccionner une date de début.',
            'date_start.after' => 'Veuillez séleccionner une date à partie d\'aujourd\'hui.',
            'date_end.required' => 'Veuillez séleccionner une date de fin.',
            'date_end.after' => 'La date de fin doit être après la date de début.',
        ])->validate();
        
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
        /**
         * Calculate the difference between the original booking request and the availability
         */
        $matching_pct = 0;
        $matching_start_pct = 0;
        $matching_end_pct = 0;

        if ($booking->request) {
            $request_start      = $booking->request->start;
            $request_end        = $booking->request->end;
            $availability_start = $booking->request->availability->start;
            $availability_end   = $booking->request->availability->end;

            // Durations
            $booking_duration       = $request_start->diffInMinutes($request_end);
            $availability_duration  = $availability_start->diffInMinutes($availability_end);

            // Differences between starting and ending hours
            $booking_delay_start = ($request_start->lte($availability_start))
                ? $request_start->diffInMinutes($availability_start)
                : 0;
            $booking_delay_end = ($request_end->gte($availability_end))
                ? $request_end->diffInMinutes($availability_end)
                : 0;

            // Percentages calculation
            $matching_pct = ($availability_duration * 100) / $booking_duration;
            $matching_start_pct = ($booking_delay_start * 100) / $booking_duration;
            $matching_end_pct = ($booking_delay_end * 100) / $booking_duration;
        }

        /**
         * User avatars
         * select an avatar based on the user ID, randomize it enough to get 2 different images
         */
        $avatars = ['img/dummy_avatar_1.jpg', 'img/dummy_avatar_2.jpg', 'img/dummy_avatar_3.jpg'];
        $user_avatar_id_1 = $booking->user->id % 3;
        $user_avatar_id_2 = $booking->substitute->id % 3;
        $avatar_1 = $avatars[$user_avatar_id_1];
        $avatar_2 = $avatars[$user_avatar_id_2];

        if ($user_avatar_id_1 == $user_avatar_id_2) {
            $others = array_values(array_except($avatars, $user_avatar_id_1)); // remove the same avatar from the array
            $avatar_2 = head($others); // retrieve the first one
        }

        return view('booking.show', [
            'booking'               => $booking,
            'matching_pct'          => $matching_pct,
            'matching_start_pct'    => $matching_start_pct,
            'matching_end_pct'      => $matching_end_pct,
            'avatar1'               => $avatar_1,
            'avatar2'               => $avatar_2,
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
