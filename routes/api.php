<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PatientController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();});

// users
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);

// roles
Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles', [RoleController::class, 'store']);


// appointments
Route::get('/createAppointment', [AppointmentController::class, 'index']);
Route::post('/createAppointment', [AppointmentController::class, 'store']);
Route::post('/users', [UserController::class, 'store']);
// Route::get('/users', [UserController::class, 'index']);

// Route for listing all roles
Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles', [RoleController::class, 'store']);