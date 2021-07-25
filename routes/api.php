<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DangerousAreaController;
use App\Http\Controllers\disasterCategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('dangerous-areas', [DangerousAreaController::class, 'index'])->name('dangerous_areas.index');
Route::post('dangerous-areas', [DangerousAreaController::class, 'store'])->name('dangerous_areas.store');
Route::delete('dangerous-areas/{dangerousArea}', [DangerousAreaController::class, 'destroy'])->name('dangerous_areas.store');
Route::post('filter-areas', [DangerousAreaController::class, 'filterAreas']);

Route::get('disaster-categories', [disasterCategoryController::class, 'index']);

