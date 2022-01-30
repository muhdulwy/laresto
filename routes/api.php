<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);
Route::post('uploadImage', [MenuController::class, 'uploadImage']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('menu', MenuController::class)->except('create', 'edit');
    Route::post('logout', [LoginController::class, 'logout']);
});


Route::get('login', function () {
    return response()->json(['error' => 'Unauthenticted'], 401);
})->name('login');

Route::fallback(function(){
    return response()->json(['status' => 404, 'message' => 'Not Found.']);
})->name('api.fallback.404');

