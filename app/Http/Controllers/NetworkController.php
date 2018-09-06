<?php

namespace App\Http\Controllers;

use App\Network;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class NetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: restrict listing by current user
        $networks = Network::all();
        return view('network.index', ['networks' => $networks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('network.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
        ]);

        // if no color is defined, choose one randomly
        if ($request->color) {
            $color = strtolower($request->color);
        } else {
            $color = array_random(config('network.colors'));
        }
        
        $network = new Network();
        $network->name      = $request->name;
        $network->color     = $color;
        $network->owner_id  = 1; // TODO: change to logged in user
        $network->save();

        return redirect()->route('networks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function show(Network $network)
    {
        $ads            = $network->ads;
        $availabilities = $network->availabilities;

        return view('network.show', [
            'network'           => $network,
            'ads'               => $ads,
            'availabilities'    => $availabilities
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function edit(Network $network)
    {
        return view('network.edit', ['network' => $network]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Network $network)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
        ]);
        
        $network->name      = $request->name;
        $network->color     = strtolower($request->color);
        $network->save();

        return redirect()->route('networks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function destroy(Network $network)
    {
        //
    }

    public function ads(Network $network)
    {
        $ads = $network->ads()->orderBy('created_at', 'desc')->get();

        return view('network.ads', [
            'network'   => $network,
            'ads'       => $ads
        ]);
    }
}
