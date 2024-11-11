<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\MoviesController;
use App\Http\Controllers\NameController;

// Movies routes
Route::get('/movies', [MoviesController::class, 'index']); // GET all movies
Route::get('/movies/{id}', [MoviesController::class, 'show']); // GET a single movie
Route::post('/movies', [MoviesController::class, 'store']); // POST a new movie

// Directors routes
Route::get('/name', [NameController::class, 'index']); // GET all directors
Route::get('/name/{id}', [NameController::class, 'show']); // GET a single director
Route::post('/name', [NameController::class, 'store']); // POST a new director
