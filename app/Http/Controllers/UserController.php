<?php

namespace App\Http\Controllers;

use App\Availability;
use App\Booking;
use App\BookingRequest;
use App\Diploma;
use App\Network;
use App\Nursery;
use App\User;
use App\Workgroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // Get future availabilities
        $availabilities = $user->availabilities()
            ->where('start', '>=', now())
            ->orderBy('start')
            ->get();

        // Get approved future bookings
        $bookings = $user->bookings()
            ->with('nursery')
            ->where('start', '>=', now())
            ->where('status', '=', Booking::STATUS_APPROVED)
            ->orderBy('start')
            ->get();

        // Get pending future booking requests
        $bookingRequests = $user->bookingRequests()
            ->where('start', '>=', now())
            ->where('status', '=', BookingRequest::STATUS_PENDING)
            ->with('nursery')
            ->orderBy('start')
            ->get();

        // Get a user's own booking requests
        $userBookingRequests = $user->ownBookingRequests()
            ->where('start', '>=', now())
            ->with('nursery')
            ->orderBy('start')
            ->get();

        $avatars = ['img/dummy_avatar_1.jpg', 'img/dummy_avatar_2.jpg', 'img/dummy_avatar_3.jpg'];

        return view('user.show', [
            'user'                  => $user,
            'availabilities'        => $availabilities,
            'bookings'              => $bookings,
            'bookingRequests'       => $bookingRequests,
            'userBookingRequests'   => $userBookingRequests,
            'avatar'                => $avatars[$user->id % 3]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // TODO: restrict to the user data
        $nurseries          = Nursery::orderBy('name', 'asc')->get();
        $managedNetworks    = Network::all();
        $workgroups         = Workgroup::all();
        $diplomas           = Diploma::all();

        $currentNetworksKeys    = array_values(array_flatten((array)$user->networks->keyBy('id')->keys()));
        $currentWorkgroups      = array_values(array_flatten((array)$user->workgroups->keyBy('id')->keys()));

        return view('user.edit', [
            'user'                  => $user,
            'nurseries'             => $nurseries,
            'managedNetworks'       => $managedNetworks,
            'currentNetworksKeys'   => $currentNetworksKeys,
            'workgroups'            => $workgroups,
            'currentWorkgroups'     => $currentWorkgroups,
            'diplomas'              => $diplomas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->phone        = $request->phone;
        $user->nursery_id   = $request->nursery;
        $user->diploma_id   = $request->diploma;
        $user->save();

        // networks
        $network_ids = [];
        if ($request->networks) {
            $network_ids = array_values($request->networks);
        }
        $user->networks()->sync($network_ids);

        // workgroups
        $workgroup_ids = [];
        if ($request->workgroups) {
            $workgroup_ids = array_values($request->workgroups);
        }
        $user->workgroups()->sync($workgroup_ids);

        return redirect()->route('users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    public function availabilities(User $user)
    {
        return view('user.availabilities', ['user' => $user]);
    }

    public function bookings(User $user)
    {
        global $bookings;
        $bookings       = [];

        // TODO: retrieve bookings for the current user
        $user->bookings()->orderBy('start')->each(function ($data){
            global $bookings;

            $start  = Carbon::parse($data->start);
            $end    = Carbon::parse($data->end);

            $bookings[] = (object)[
                'day_start'     => $start->format('d.m.Y'),
                'day_end'       => $end->format('d.m.Y'),
                'hour_start'    => $start->format('H\hi'),
                'hour_end'      => $end->format('H\hi'),
                'nursery'       => $data->nursery,
            ];
        });

        return view('user.bookings', [
            'user'      => $user,
            'bookings'  => $bookings
        ]);
    }

    /**
     * Look through the availabilities for a specific user and date
     * and return its free time
     *
     * @param User $user
     * @param Carbon $date
     * @return array
     */
    public static function getAvailableSlots(User $user, Carbon $date)
    {
        $day_start  = $date->copy()->hour(config('nursery.opening_time'))->minute(0);
        $day_end    = $date->copy()->hour(config('nursery.closing_time'))->minute(0);

        // get related bookings
        $availabilities = Availability::whereYear('start', $day_start->format('Y'))
            ->whereMonth('start', $day_start->format('m'))
            ->whereDay('start', $day_start->format('d'))
            ->where('user_id', $user->id)
            ->orderBy('start')
            ->get();

        // init
        $start      = $day_start->copy();
        $free_min   = $day_start->diffInMinutes($day_end);
        $slots      = [];

        // loop through the associated bookings
        foreach ($availabilities as $key => $availability) {

            // store each booking duration
            if ($availability->start->lt($day_start)) {
                $free_min -= $availability->end->diffInMinutes($day_start);
            } elseif ($availability->end->gt($day_end)) {
                $free_min -= $availability->start->diffInMinutes($day_end);
            } else {
                $free_min -= $availability->start->diffInMinutes($availability->end);
            }

            // If this is the last booking and it is exactly the same length, exit early
            if ($key == $availability->count() &&
                $availability->start->equaltTo($day_start) &&
                $availability->end->equaltTo($day_end)
            ) {
                break;
            }

            // register available slots
            if ($availability->start->equalTo($start)) {
                $start->addMinutes($availability->start->diffInMinutes($availability->end));
            } else {
                $slot_start = $start->copy();
                $slot_end   = $start->copy()->addMinutes($start->diffInMinutes($availability->start));
                $start      = $availability->end;

                $slots[] = ['start' => $slot_start, 'end' => $slot_end];
            }

            // if the last booking ends before the availability, retrieve the ending slot
            if ($key == $availabilities->count() - 1 && $availability->end->lt($day_end)) {
                $slot_start = $availability->end->copy();
                $slot_end   = $slot_start->copy()->addMinutes($availability->end->diffInMinutes($day_end));

                $slots[] = ['start' => $slot_start, 'end' => $slot_end];
            }
        }

        // if no availabilities are registered for this user, he is available all day long
        if (!$availabilities->count()) {
            $slots[] = ['start' => $day_start, 'end' => $day_end];
        }

        // prep return data
        $data = [
            'total_freetime'        => $day_start->diffInMinutes($day_end),
            'available_freetime'    => $free_min,
            'slots'                 => $slots
        ];

        return $data;
    }
}
