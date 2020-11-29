<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\PropertyAnalyticController;

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
$CURRENT_VERSION = '2020-11';

Route::get("/$CURRENT_VERSION/properties", [PropertyController::class, 'index']);
Route::post("/$CURRENT_VERSION/properties", [PropertyController::class, 'store']);
Route::get("/$CURRENT_VERSION/properties/{property}", [PropertyController::class, 'show']);
Route::get("/$CURRENT_VERSION/properties/{property_id}/analytics", [PropertyController::class, 'showByProperty']);
Route::post("/$CURRENT_VERSION/properties/{property_id}/analytics", [PropertyAnalyticController::class, 'store']);
Route::put("/$CURRENT_VERSION/properties/{property_id}/analytics/{id}", [PropertyAnalyticController::class, 'update']);
