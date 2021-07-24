<?php

namespace App\Http\Controllers;

use App\Models\DangerousArea;
use Illuminate\Http\Request;
use App\Http\Resources\DangerousArea as DangerousAreaResource;

class DangerousAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dangerousAreas = DangerousArea::all();
        return DangerousAreaResource::collection($dangerousAreas);
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
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'disaster_category_id' => 'required'
        ]);

        $data = DangerousArea::create([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'disaster_category_id' => $request->disaster_category_id
        ]);
        
        return new DangerousAreaResource($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DangerousArea  $dangerousArea
     * @return \Illuminate\Http\Response
     */
    public function show(DangerousArea $dangerousArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DangerousArea  $dangerousArea
     * @return \Illuminate\Http\Response
     */
    public function edit(DangerousArea $dangerousArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DangerousArea  $dangerousArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DangerousArea $dangerousArea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DangerousArea  $dangerousArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(DangerousArea $dangerousArea)
    {
        $previousData = $dangerousArea;
        $dangerousArea->delete();

        return response()->json([
            'message' => 'Data is sucesfully deleted',
            'data' => $previousData
        ], 200);
    }
}
