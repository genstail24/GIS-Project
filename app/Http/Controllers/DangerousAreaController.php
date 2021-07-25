<?php

namespace App\Http\Controllers;

use App\Models\DangerousArea;
use Illuminate\Http\Request;
use App\Http\Resources\DangerousArea as DangerousAreaResource;

class DangerousAreaController extends Controller
{
    public function __construct() {
        $this->middleware('is.admin')->except(['index', 'filterAreas']);
    }

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
        $validatedData = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'disaster_category_id' => 'required'
        ]);
        $data = DangerousArea::create($validatedData);
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
        $validatedData = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        $dangerousArea->update($validatedData);
        return response()->json([
            'message' => 'data sucessfully updated',
            'data' => new DangerousAreaResource($dangerousArea)
        ]);
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

    public function filterAreas(Request $request){

        $query = DangerousArea::query();
        $search = $request->search;
        $categories = $request->categories;

        if(!empty($categories)){
            $query->whereIn('disaster_category_id', $categories)->get();
        }
        if(!empty($search)){
            $query->isWithinMaxDistance($search, 10)->get();
        }

        if(empty($categories) && empty($search)){
            $data = [];
        }else{
            $data = $query->get();
        }

        return DangerousAreaResource::collection($data);
    }
}
