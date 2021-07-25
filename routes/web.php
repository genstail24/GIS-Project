<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\MapController;
use App\Http\Controllers\DisasterCategoryController;
use App\Http\Controllers\DangerousAreaController;

Route::group(['middleware' => 'auth'], function() {
	// map page
	Route::get('/', [MapController::class, 'index'])->name('home');

	// disaster categories
	Route::resource('/disaster-categories', DisasterCategoryController::class)->name('*', 'disaster-categories');

	// dangeorus areas
	Route::get('dangerous-areas', [DangerousAreaController::class, 'index'])->name('dangerous_areas.index');
	Route::post('dangerous-areas', [DangerousAreaController::class, 'store'])->name('dangerous_areas.store');
	Route::put('dangerous-areas/{dangerousArea}', [DangerousAreaController::class, 'update'])->name('dangerous_areas.update');
	Route::delete('dangerous-areas/{dangerousArea}', [DangerousAreaController::class, 'destroy'])->name('dangerous_areas.store');
	Route::post('filter-areas', [DangerousAreaController::class, 'filterAreas']);
	Route::get('get-disaster-categories', [disasterCategoryController::class, 'ajaxIndex']);
});

Auth::routes();

