<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;


Route::post('/users', [UserController::class, 'store']);
// Route::get('/users', [UserController::class, 'index']);

// Route for listing all roles
// Route::get('/roles', [RoleController::class, 'index']);
// Route::post('/roles', [RoleController::class, 'store']);