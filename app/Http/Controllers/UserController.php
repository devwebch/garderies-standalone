<?php

namespace App\Http\Controllers;

use App\Nursery;
use App\User;
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
        // TODO: Fuck scopes
        global $availabilities, $bookings;
        $availabilities = [];
        $bookings       = [];

        $user->availabilities()->orderBy('start')->each(function ($data){
            global $availabilities;

            $start  = Carbon::parse($data->start);
            $end    = Carbon::parse($data->end);

            $availabilities[] = (object)[
                'day_start'     => $start->format('d.m.Y'),
                'day_end'       => $end->format('d.m.Y'),
                'hour_start'    => $start->format('H\hi'),
                'hour_end'      => $end->format('H\hi')
            ];
        });

        $user->bookings()->orderBy('start')->each(function ($data){
            global $bookings;

            $start  = Carbon::parse($data->start);
            $end    = Carbon::parse($data->end);

            $bookings[] = (object)[
                'day_start'     => $start->format('d.m.Y'),
                'day_end'       => $end->format('d.m.Y'),
                'hour_start'    => $start->format('H\hi'),
                'hour_end'      => $end->format('H\hi')
            ];
        });

        return view('user.show', [
            'user'              => $user,
            'availabilities'    => $availabilities,
            'bookings'          => $bookings
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
        $nurseries = Nursery::orderBy('name', 'asc')->get();

        return view('user.edit', [
            'user'      => $user,
            'nurseries' => $nurseries
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
        $user->name         = $request->name;
        $user->nursery_id   = $request->nursery;
        $user->save();

        return redirect()->route('users.index');
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

    public function search()
    {
        return view('user.search');
    }
}
