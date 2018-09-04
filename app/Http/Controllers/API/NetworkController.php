<?php

namespace App\Http\Controllers\API;

use App\Network;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Network as NetworkResource;

class NetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('sort')) {
            list($sortCol, $sortDir) = explode('|', $request->get('sort'));
            $query = Network::with('owner')->orderBy($sortCol, $sortDir);
        } else {
            $query = Network::with('owner')->orderBy('networks.name', 'asc');
        }
    
        $query->join('users', 'users.id', '=', 'owner_id');
        $query->join('nurseries', 'nurseries.id', '=', 'network_id');

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('networks.name', 'like', $value)
                    ->orWhere('users.name', 'like', $value);
            });
        }

        $perPage = $request->has('per_page') ? (int) $request->per_page : null;

        $data = $query->withCount('users')->withCount('nurseries')->withCount('ads')->paginate($perPage);

        return response()->json($data);
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
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function show(Network $network)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function destroy(Network $network)
    {
        $network->delete();

        return response()->json([
            'status'    => 'Network deleted',
            'redirect'  => route('networks.index')
        ]);
    }
}
