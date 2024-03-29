<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/leaderboard', [UserController::class, 'leaderboard']);

Route::get('/photos/seed', [ImageController::class, 'seed']);

Route::get('/photos', [ImageController::class, 'random']);

Route::post('/users/register', [UserController::class, 'register']);

Route::post('/users/login', [UserController::class, 'login']);

Route::patch('/users/highscore', [UserController::class, 'updateHighscore']);
