<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

Route::get('/home', function () {
    return view('home');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::get('/createAppointment', function () {
    return view('createAppointment');
});

// Route::get('/get-patient-name/{id}', function($id) {
//     $patient = Patient::find($id);
//     return 
// })

Route::get('/roles', function (){
    return view('roles');
});
