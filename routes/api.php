<?php

use App\Http\Controllers\api\Auth\LoginController;
use App\Http\Controllers\api\Auth\ProfileController;
use App\Http\Controllers\api\Auth\RegisterController;
use App\Http\Controllers\api\Game\CreateController;
use App\Http\Controllers\api\Game\IndexController as GameIndexController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/generate/token/{id}', [ProfileController::class, 'generateToken']);
Route::get('/profile/{id}', [ProfileController::class, 'getProfileById']);

Route::get('/users', [ProfileController::class, 'getAllUser']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'getProfileByToken']);
    Route::patch('/profile/update', [ProfileController::class, 'updateProfile']);

    Route::patch('/password/update', [LoginController::class, 'changePassword']);

    Route::post('/game/post', [CreateController::class, 'postGame']);
});

Route::get('leaderboard', [GameIndexController::class, 'getLeaderBoard']);
