<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Nursery as NurseryResource;
use App\Nursery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NurseryController extends Controller
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
            $query = Nursery::orderBy($sortCol, $sortDir);
        } else {
            $query = Nursery::orderBy('nurseries.name', 'asc');
        }
        
        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('nurseries.name', 'like', $value);
            });
        }
    
        $perPage = $request->has('per_page') ? (int) $request->per_page : null;
    
        $data = $query->withCount('users')->paginate($perPage);
    
        return response()->json($data);
        
        return NurseryResource::collection(\App\Nursery::orderBy('name')->get());
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
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function show(Nursery $nursery)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nursery  $nursery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nursery $nursery)
    {
        $nursery->delete();

        return response()->json([
            'status'    => 'Nursery deleted',
            'redirect'  => route('nurseries.index')
        ]);
    }
}
