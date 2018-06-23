<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User as UserResource;
use App\Network;
use App\Nursery;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
    
        $users = DB::table('users')
            ->select(DB::raw('users.*, networks.id as network_id, networks.name as network_name, nurseries.id as nursery_id, nurseries.name as nursery_name'))
            ->join('network_user', 'users.id', '=', 'user_id')
            ->join('networks', 'networks.id', '=', 'network_id')
            ->join('nurseries', 'nurseries.id', '=', 'nursery_id')
            ->where('users.id', '!=', 1);
    
        if ($request->exists('filter')) {
            $users->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('users.name', 'like', $value)
                    ->orWhere('users.email', 'like', $value)
                    ->orWhere('users.phone', 'like', $value)
                    ->orWhere('networks.name', 'like', $value)
                    ->orWhere('nurseries.name', 'like', $value);
            });
        }
    
        if ($request->get('sort')) {
            list($sortCol, $sortDir) = explode('|', $request->get('sort'));
            $users->orderBy($sortCol, $sortDir);
        } else {
            $users->orderBy('users.name', 'asc');
        }
        
        $perPage = $request->has('per_page') ? (int) $request->per_page : null;
        $data = $users->paginate($perPage);
        
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
