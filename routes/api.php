<?php

use App\Http\Controllers\UserAuthController;
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


//user auth routes
Route::prefix('auth')->group(function () {
    Route::post('login', [UserAuthController::class , 'login']);
    Route::post('register', [UserAuthController::class , 'register']);
    Route::middleware('auth:sanctum')->post('logout', [UserAuthController::class , 'logout']);
    Route::middleware('auth:sanctum')->get('me', [UserAuthController::class , 'me']);
});
