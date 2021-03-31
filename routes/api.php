<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;

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

Route::post('/login',    [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/movie',     [MovieController::class, 'getMovieByTitle']);
Route::get('/movie-id',  [MovieController::class, 'getMovieById']);

Route::post('/movie',    [MovieController::class, 'storeMovieByTitle']);
Route::post('/movie-id', [MovieController::class, 'storeMovieById']);

Route::post('store-movie', [MovieController::class, 'storeMovie']);

Route::get('/user',      [AuthController::class, 'user'])->middleware('auth:api');

