<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisasterCategory;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DisasterCategory::all();
        return view('pages.map.index', [
            "categories" => $categories
        ]);
    }
}
