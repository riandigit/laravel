<?php

use App\Http\Controllers\AuthControllers;
use App\Http\Controllers\UserControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

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

// Route::get('/users',[UserControllers::class,'index']);
//public route
Route::middleware('checktoken')->post('/register', [AuthControllers::class, 'register']);
Route::middleware('checktoken')->post('/login', [AuthControllers::class, 'login']);
// Route::get('/gettoken',[UserControllers::class,'createtoken']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/member/getallmember', [MemberController::class, 'getAllMember']);
    Route::get('/member/getmemberbyid/{id}', [MemberController::class, 'getMemberbyId']);
    Route::post('/member/editAccount/{id}', [MemberController::class, 'updateMember']);
    Route::post('/member/changepassword/{id}', [MemberController::class, 'changePassword']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });