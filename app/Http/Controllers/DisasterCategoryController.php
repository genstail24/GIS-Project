<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DisasterCategory;
use App\Http\Resources\DisasterCategory as DisasterCategoryResource;
use DataTables;

class DisasterCategoryController extends Controller
{
    public function __construct() {
        $this->middleware('is.admin')->except(['show', 'ajaxIndex']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return response()->json([ data-toggle="modal" data-target="#EditDisasterCategoryModal"
        //     'data' => $disasterCategories
        // ], 200);
         if ($request->ajax()) {
            $data = DisasterCategory::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<button class="delete-button btn btn-danger" data-id="' . $row->id . '" id="disaster-category-delete-button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="edit-button btn btn-success" data-id="' . $row->id . '" id="edit-disaster-category-button" >
                                        <i class="fas fa-edit"></i>
                                    </button>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addColumn('disasterAreas', function (DisasterCategory $disasterCategory) {
                        return $disasterCategory->dangerousAreas()->count();
                    })
                    ->make(true);
        }

        $disasterCategories = DisasterCategory::all();
        return view('pages.disasterCategory.index', [
            'disasterCategories' => $disasterCategories
        ]);
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
            'name' => 'required'
        ]);
        DisasterCategory::create($validatedData);
        return response()->json([
            'message' => 'Data is sucessfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DisasterCategory  $disasterCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DisasterCategory $disasterCategory)
    {
        return new DisasterCategoryResource($disasterCategory);
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
        $validatedData = $request->validate([
            'name' => 'required'
        ]);
        $disasterCategory->update($validatedData);
        return response()->json([
            'message' => 'Data is sucessfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DisasterCategory  $disasterCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DisasterCategory $disasterCategory)
    {
        $disasterCategory->delete();

        return response()->json([
            'message' => 'Data is sucessfully deleted'
        ]);
    }

    /**
     * Custom method
     *
     */
    public function ajaxIndex(){
        $disasterCategories = DisasterCategory::all();
        return DisasterCategoryResource::collection($disasterCategories);
    }
}
