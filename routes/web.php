<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;




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



Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'store']);

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

Route::get('/patient-assignment', [DashboardController::class, 'showPatientAssignmentForm'])->name('patient.assignment');
Route::get('/search-patient', [DashboardController::class, 'searchPatientById']);
Route::post('/patient-assignment', [DashboardController::class, 'storePatientAssignment']);

Route::get('/patientList', [PatientController::class, 'patientList'])->name('patientList');



Route::post('/patient', [PatientController::class, 'store']);
Route::get('/patient', [PatientController::class, 'patientsPage']);

Route::get('/employees', [EmployeesController::class, 'index']);
Route::post('/employees', [EmployeesController::class, 'store']);

Route::get('/roster', [RosterController::class, 'showRosterForm']);
Route::post('/roster', [RosterController::class, 'store']);

// Route::get('/rosterList', [RosterController::class, 'rosterList'])->name('rosterList');
// Route::post('/rosterList', [RosterController::class, 'populateRosterListForm']);
Route::get('/rosterList', [RosterController::class, 'showRosterListForm'])->name('rosterList');

Route::get('/appointment', [AppointmentController::class, 'appointmentForm'])->name(name: 'appointment.appointmentForm');
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');

// Route::get('/payment', [PaymentController::class, 'paymentPage'])->name('payments.paymentPage'); // List all payments
// Route::post('/payment', [PaymentController::class, 'store'])->name('payments.store'); // Create a new paymentuse App\Http\Controllers\PaymentController;

Route::get('/payment', [PaymentController::class, 'paymentPage']); // To calculate total due dynamically
Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store'); 
Route::post('/payments/pay', [PaymentController::class, 'pay'])->name('payments.pay');
