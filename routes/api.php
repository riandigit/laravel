<?php

use App\Http\Controllers\AuthControllers;
use App\Http\Controllers\UserControllers;
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

Route::get('/users',[UserControllers::class,'index']);
//public route
Route::middleware('checktoken')->post('/register',[AuthControllers::class,'register']);
Route::middleware('checktoken')->post('/login',[AuthControllers::class,'login']);
Route::get('/gettoken',[UserControllers::class,'createtoken']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });