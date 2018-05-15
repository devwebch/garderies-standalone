<?php

namespace App\Http\Controllers;

use App\Nursery;
use Illuminate\Http\Request;

class NurseryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('nursery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nursery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nursery = new Nursery();
        $nursery->name = $request->name;
        $nursery->save();

        return redirect()->route('nurseries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function show(Nursery $nursery)
    {
        $bookings = $nursery->bookings;

        return view('nursery.show', [
            'nursery'   => $nursery,
            'bookings'  => $bookings
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function edit(Nursery $nursery)
    {
        return view('nursery.edit', ['nursery' => $nursery]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nursery $nursery)
    {
        $nursery->name = $request->name;
        $nursery->save();

        return redirect()->route('nurseries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nursery $nursery)
    {
        // If there are no users bound to this nursersy, proceed
        if ($nursery->users->count() == 0) {
            // Delete nursery
            $nursery->delete();
        } else {
            // Retrieve the associated users
            $users = $nursery->users;

            // Loop through it
            foreach($users as $user) {
                $user->nursery_id = 0;
                $user->save();
            }

            // Delete nursery
            $nursery->delete();
        }

        return redirect()->route('nurseries.index');
    }
}
