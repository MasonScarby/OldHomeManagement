<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// Your route definitions here



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
// */

Route::get('/', function () {
    return view('login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/approval', [DashboardController::class, 'approval'])->name('approval');
    Route::post('/approve-users', [DashboardController::class, 'approveUsers'])->name('approveUsers');
    Route::get('/doctorHome', [DashboardController::class, 'doctorHome'])->name('doctorHome');
    Route::get('/caregiverHome', [DashboardController::class, 'caregiverHome'])->name('caregiverHome');
    Route::get('/patientHome', [DashboardController::class, 'patientHome'])->name('patientHome');
    Route::get('/family_memberHome', [DashboardController::class, 'familyMemberHome'])->name('family_memberHome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user', [UserController::class, 'showRegisterForm']);
Route::post('/user', [UserController::class, 'store']);

Route::post('/patient', [PatientController::class, 'store']);
Route::get('/patient', [PatientController::class, 'patientsPage']);

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
