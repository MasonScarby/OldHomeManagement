<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function appointmentForm()
    {
        $patients = User::join('roles', 'users.role_id', '=', 'roles.id') 
            ->where('roles.role_name', 'Patient')
            ->select('users.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
            ->get();

        $doctors = User::whereHas('role', function($query) {
            $query->where('role_name', 'Doctor');
        })->get(['id', 'first_name', 'last_name']);
        
        return view('appointment', compact('patients', 'doctors'));
    }

    
    public function index()
    {
        $appointments = Appointment::all();

        return response()->json([
            'success' => true,
            'data' => $appointments
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id', 
            'date' => 'required|date',
        ]);
    
        $appointment = Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'date' => $validated['date'],
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'data' => $appointment,
        ], 201);
    }

}
