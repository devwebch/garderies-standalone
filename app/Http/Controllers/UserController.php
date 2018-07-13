<?php

namespace App\Http\Controllers;

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
        $availabilities = $user->availabilities()
            ->where('start', '>=', now())
            ->orderBy('start')
            ->get();

        $bookings = $user->bookings()
            ->with('nursery')
            ->where('start', '>=', now())
            ->orderBy('start')
            ->get();

        $avatars = ['img/dummy_avatar_1.jpg', 'img/dummy_avatar_2.jpg', 'img/dummy_avatar_3.jpg'];

        return view('user.show', [
            'user'              => $user,
            'availabilities'    => $availabilities,
            'bookings'          => $bookings,
            'avatar'            => $avatars[rand(0, count($avatars) - 1)]
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
}
