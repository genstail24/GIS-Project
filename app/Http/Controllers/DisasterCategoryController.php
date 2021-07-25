<?php

namespace App\Http\Controllers;

use App\Models\DisasterCategory;
use Illuminate\Http\Request;

class DisasterCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disasterCategories = DisasterCategory::all();
        return response()->json([
            'data' => $disasterCategories
        ], 200);
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
     * @param  \App\Models\DisasterCategory  $disasterCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DisasterCategory $disasterCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DisasterCategory  $disasterCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(DisasterCategory $disasterCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DisasterCategory  $disasterCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DisasterCategory $disasterCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DisasterCategory  $disasterCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DisasterCategory $disasterCategory)
    {
        //
    }
 

}
