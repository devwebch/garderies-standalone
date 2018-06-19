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
    
        if ($request->get('sort')) {
            list($sortCol, $sortDir) = explode('|', $request->get('sort'));
            $query = User::with('nursery')->with('networks')->orderBy($sortCol, $sortDir);
        } else {
            $query = User::with('nursery')->with('networks')->orderBy('users.name', 'asc');
        }
    
       /* $query->join('networks', 'users.id', '=', 'owner_id');
        $query->join('nurseries', 'networks.id', '=', 'network_id');*/
    
        /*if ($nursery) {
            $query->where('nurseries.id', '=', $nursery);
        }
        
        if ($network) {
            $query->where('networks.id', '=', $network);
        }
        
        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('networks.name', 'like', $value)
                    ->orWhere('nurseries.name', 'like', $value)
                    ->orWhere('users.name', 'like', $value);
            });
        }*/
    
        $perPage = $request->has('per_page') ? (int) $request->per_page : null;
    
        $data = $query->paginate($perPage);
    
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
