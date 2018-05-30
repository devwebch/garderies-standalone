<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User as UserResource;
use App\Network;
use App\Nursery;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nursery = $request->nursery;
        $network = $request->network;

        if ($nursery) {
            $collection = UserResource::collection(Nursery::find($nursery)->users()->orderBy('name', 'ASC')->get());
        } elseif ($network) {
            $collection = UserResource::collection(Network::find($network)->users()->orderBy('name', 'ASC')->get());
        } else {
            $collection = UserResource::collection(\App\User::orderBy('name', 'ASC')->get());
        }

        return response()->json($collection);
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
        //
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
        //
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

        return response()->json([
            'status'    => 'User deleted',
            'redirect'  => route('users.index')
        ]);
    }
}
