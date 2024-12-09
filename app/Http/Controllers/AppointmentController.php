<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prescription;
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
    
        return redirect()->back()->with('success', 'Appointment created successfully!');

    }

    public function filter(Request $request)
{
    // Build query to fetch appointments
    $query = Appointment::query();

    // Apply filters if available
    if ($request->has('filter') && $request->has('filter_by')) {
        $filter = $request->input('filter');
        $filterBy = $request->input('filter_by');

        // Patient name filter
        if ($filterBy == 'name') {
            $query->whereHas('patient.user', function ($query) use ($filter) {
                $query->where('first_name', 'like', "%$filter%")
                    ->orWhere('last_name', 'like', "%$filter%");
            });
        }
        // Date filter
        elseif ($filterBy == 'date') {
            $query->whereDate('date', 'like', "%$filter%");
        }
        // Comment filter
        elseif ($filterBy == 'comment') {
            $query->whereHas('prescription', function ($query) use ($filter) {
                $query->where('comment', 'like', "%$filter%");
            });
        }
        // Meds filters
        elseif (in_array($filterBy, ['morning_med', 'afternoon_med', 'night_med'])) {
            $query->whereHas('prescription', function ($query) use ($filter, $filterBy) {
                $query->where($filterBy, 'like', "%$filter%");
            });
        }
    }

    // Fetch the filtered appointments
    $completedAppointments = $query->where('completed', true)->get();
    $upcomingAppointments = Appointment::where('completed', false)->get();

    // Fetch associated prescriptions
    $prescriptions = Prescription::whereIn('appointment_id', $completedAppointments->pluck('id'))->get();

    // Return filtered data to the view
    return view('appointments.completedAppointments', compact('completedAppointments', 'upcomingAppointments', 'prescriptions'));
}
}
