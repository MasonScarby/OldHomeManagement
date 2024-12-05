<?php

use App\Http\Controllers\DoctorController;
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
use App\Http\Controllers\PatientLogsController;
use App\Http\Controllers\AdminReportController;

Route::get('/', function () {
    return view('login');
});
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::get('/approval', [DashboardController::class, 'approval'])->name('approval');
    Route::post('/approve-users', [DashboardController::class, 'approveUsers'])->name('approveUsers');
    Route::get('/doctorList', [DoctorController::class, 'doctorList'])->name('doctorList');
    Route::get('/caregiverHome', [DashboardController::class, 'caregiverHome'])->name('caregiverHome');
    Route::get('/patientHome', [DashboardController::class, 'patientHome'])->name('patientHome');
    Route::get('/family_memberHome', [DashboardController::class, 'familyMemberHome'])->name('family_memberHome');
});



Route::post('/patient-logs', [PatientLogsController::class, 'storeOrUpdate'])->name('patientLogs.storeOrUpdate'); // Store or Update log
Route::get('/patient/logs/{patientId}/{date}', [PatientLogsController::class, 'getLogByDate'])->name('patient.logs');
Route::get('/patient/home', [PatientLogsController::class, 'index'])->name('patient.home'); // Display patient log home page
Route::get('/family-member/logs', [PatientLogsController::class, 'getLogForFamily'])->name('familyMember.logs');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'store']);



Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');



Route::get('/patient-assignment', [PatientController::class, 'showPatientAssignmentForm'])->name('patient.assignment');
Route::get('/search-patient', [PatientController::class, 'searchPatientById']);
Route::post('/patient-assignment', [PatientController::class, 'storePatientAssignment']);
Route::get('/patientList', [PatientController::class, 'patientList'])->name('patientList');

Route::post('/patient', [PatientController::class, 'store']);
Route::get('/patient', [PatientController::class, 'patientsPage']);

Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
Route::post('/employees', [EmployeesController::class, 'store']);
Route::put('/employees/update-salary', [EmployeesController::class, 'updateSalary'])->name('employees.updateSalary');


Route::get('/roster', [RosterController::class, 'showRosterForm']);
Route::post('/roster', [RosterController::class, 'store']);
Route::get('/rosterList', [RosterController::class, 'showRosterListForm'])->name('rosterList');



Route::get('/appointment', action: [AppointmentController::class, 'appointmentForm'])->name(name: 'appointment.appointmentForm');
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');



Route::get('/payment', [PaymentController::class, 'paymentPage']); // To calculate total due dynamically
Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store'); 
Route::post('/payments/pay', [PaymentController::class, 'pay'])->name('payments.pay');



Route::get('/rosters/create', [RosterController::class, 'index'])->name('newRoster.create');
Route::post('/rosters/store', [RosterController::class, 'store'])->name('newRoster.store');
Route::get('/rosters/list', [RosterController::class, 'show'])->name('rosters.list');



Route::get('/admin-report', [AdminReportController::class, 'index'])->name('admin-report.index');
Route::get('/admin-report/search', [AdminReportController::class, 'searchMissedActivity'])->name('admin-report.search');



Route::get('/doctorList', [PatientController::class, 'doctorList'])->name('doctorList');
Route::post('/appointments/store', [AppointmentController::class, 'storeAppointment'])->name('appointments.store');
