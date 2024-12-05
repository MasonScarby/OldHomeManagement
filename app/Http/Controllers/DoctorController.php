<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;


use Carbon\Carbon;

class DoctorController extends Controller
{
        public function doctorList(Request $request)
    {
        $doctorId = auth()->user()->id;

        // Fetching completed appointments with patients and their user info
        $completedAppointments = Appointment::with('patient.user')
            ->where('doctor_id', $doctorId)
            ->where('date', '<', today())  // Completed appointments (past dates)
            ->get();

        // Fetching upcoming appointments (future appointments) and sorting them by date ascending
        $upcomingAppointments = Appointment::with('patient.user')
            ->where('doctor_id', $doctorId)
            ->where('date', '>=', today())  // Future appointments (including today)
            ->orderBy('date', 'asc')  // Sorting appointments by date ascending
            ->get();

        // Fetch prescriptions for both completed and upcoming appointments
        $prescriptions = Prescription::where('doctor_id', $doctorId)
            ->whereIn('appointment_id', $completedAppointments->pluck('id')
                ->merge($upcomingAppointments->pluck('id'))  // Merge completed and upcoming appointment IDs
            )
            ->get();

        // Remove upcoming appointments that already have a prescription and move them to completed appointments
        $upcomingAppointments = $upcomingAppointments->filter(function ($appointment) use ($doctorId, &$completedAppointments) {
            // Check if there's a prescription for this upcoming appointment
            $prescription = Prescription::where('doctor_id', $doctorId)
                ->where('appointment_id', $appointment->id)
                ->first();

            if ($prescription) {
                // Move this appointment to completed appointments
                $completedAppointments->push($appointment);
                return false; // Don't show this in the upcoming appointments
            }

            return true; // Keep this in the upcoming appointments
        });

        // Return the view with necessary data
        return view('doctorHome', compact('completedAppointments', 'upcomingAppointments', 'prescriptions'));
    }


    public function patientOfDoctor($patientId, $appointmentId)
{
    $doctorId = auth()->user()->id;
    
    // Ensure the patient has a relationship with the user
    $patient = Patient::with('user')->findOrFail($patientId);
    
    // Fetch prescriptions for the patient
    $prescriptions = Prescription::where('patient_id', $patientId)
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Fetch the specific appointment by patient_id and appointment_id
    $appointment = Appointment::with('patient.user')
        ->where('doctor_id', $doctorId)
        ->where('patient_id', $patientId)
        ->where('id', $appointmentId)
        ->first();  // Fetch only the selected appointment
    
    // If no appointment is found, you can return an error or handle it gracefully
    if (!$appointment) {
        return redirect()->route('doctorList')->with('error', 'Appointment not found.');
    }
    
    // Return the view with necessary data, including the selected appointment
    return view('patientOfDoctor', compact('patient', 'prescriptions', 'appointment'));
}

    


    public function create(Request $request, $appointmentId)
    {
        // Load the specific appointment and related patient and doctor details
        $appointment = Appointment::with(['doctor.user', 'patient.user'])
            ->where('doctor_id', auth()->user()->id)
            ->where('id', $appointmentId)
            ->firstOrFail(); // Ensure the appointment exists

        // Return the view with the $appointment data
        return view('prescription.create', compact('appointment'));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:patients,id',
            'morning_med' => 'required|string|max:255',
            'afternoon_med' => 'required|string|max:255',
            'night_med' => 'required|string|max:255',
            'comment' => 'nullable|string|max:500',
            'date' => 'required|date',
        ]);

        Prescription::create($request->all());

        return redirect()
            ->route('doctorList')
            ->with('status', 'Prescription created successfully!');
    }


}