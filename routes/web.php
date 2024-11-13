<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/homepage', function () {
    return view('homepage');
});

Route::get('/createAppointment', function () {
    return view('createAppointment');
});

Route::get('/roles', function (){
    return view('roles');
});

Route::get('/approval', function (){
    return view('approval');
});

Route::get('/roles',[RoleController::class, 'showRoles']);
