<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
<<<<<<< HEAD
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PatientController;
=======
>>>>>>> ad26fa54b6adb5a30f5dd1d6022296267f880ff2
use App\Http\Controllers\RosterController;

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


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user', [UserController::class, 'showRegisterForm']);
Route::post('/user', [UserController::class, 'store']);

Route::post('/patient', [PatientController::class, 'store']);
Route::get('/patient', [PatientController::class, 'patientsPage']);

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return view('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/approval', [DashboardController::class, 'approval'])->name('approval');
    Route::post('/approve-users', [DashboardController::class, 'approveUsers'])->name('approveUsers');
    Route::get('/doctorHome', [DashboardController::class, 'doctorHome'])->name('doctorHome');
    Route::get('/caregiverHome', [DashboardController::class, 'caregiverHome'])->name('caregiverHome');
    Route::get('/patientHome', [DashboardController::class, 'patientHome'])->name('patientHome');
    Route::get('/family_memberHome', [DashboardController::class, 'familyMemberHome'])->name('family_memberHome');
});

//patient list
Route::get('/patient/search', [PatientController::class, 'search'])->name('patient.search');
Route::get('/patients', [PatientController::class, 'patientList']);


Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');


Route::get('/patient-assignment', [DashboardController::class, 'showPatientAssignmentForm'])->name('patient.assignment');
Route::get('/search-patient', [DashboardController::class, 'searchPatientById']);
Route::post('/patient-assignment', [DashboardController::class, 'storePatientAssignment']);



Route::get('/patientList', [PatientController::class, 'patientList'])->name('patientList');



<<<<<<< HEAD
Route::get('/employees', [EmployeesController::class, 'index']);
Route::post('/employees', [EmployeesController::class, 'store']);

Route::get('/rosters/create', [RosterController::class, 'index'])->name('newRoster.create');
Route::post('/rosters/store', [RosterController::class, 'store'])->name('newRoster.store');

Route::get('/rosters/list', [RosterController::class, 'show'])->name('rosters.list');
=======
Route::post('/patient', [PatientController::class, 'store']);
Route::get('/patient', [PatientController::class, 'patientsPage']);


Route::middleware(['auth', 'role:Admin,Supervisor'])->group(function () {
    Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
    Route::post('/employees', [EmployeesController::class, 'store']);
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::put('/employees/update-salary', [EmployeesController::class, 'updateSalary'])->name('employees.updateSalary');
});



Route::get('/roster', [RosterController::class, 'showRosterForm']);
Route::post('/roster', [RosterController::class, 'store'])->name('roster.store');

Route::get('/rosterList', [RosterController::class, 'showRosterListForm']);
Route::post('/rosterList', [RosterController::class, 'populateRosterListForm']);
>>>>>>> ad26fa54b6adb5a30f5dd1d6022296267f880ff2
