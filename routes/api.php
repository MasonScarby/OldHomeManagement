<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\PaymentController;



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

// employees
Route::get('/employees', [EmployeesController::class, 'index']);
Route::post('/employees', [EmployeesController::class, 'store']);

Route::get('/register', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store']);


Route::post('/patient', [PatientController::class, 'store']);
Route::get('/patient', [PatientController::class, 'patientsPage']);

Route::get('/employees', [EmployeesController::class, 'index']);
Route::post('/employees', [EmployeesController::class, 'store']);

Route::get('/roster', [RosterController::class, 'showRosterForm']);
Route::post('/roster', [RosterController::class, 'store'])->name('roster.store');

// Route::get('/rosterList', [RosterController::class, 'rosterList'])->name('rosterList');
// Route::post('/rosterList', [RosterController::class, 'populateRosterListForm']);
Route::get('/rosterList', [RosterController::class, 'showRosterListForm'])->name('rosterList');

Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index');
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');

// Route::get('/payment', [PaymentController::class, 'index'])->name('payments.index'); // List all payments
// Route::post('/payment', [PaymentController::class, 'store'])->name('payments.store'); // Create a new payment
Route::get('/payments/calculateTotalDue', [PaymentController::class, 'calculateTotalDue']); // To calculate total due dynamically
Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store'); 
Route::post('/payments/pay', [PaymentController::class, 'pay'])->name('payments.pay');
