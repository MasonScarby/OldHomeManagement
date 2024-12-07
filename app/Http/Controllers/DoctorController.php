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

    // Get search and filter inputs
    $filterBy = $request->input('filter_by');
    $filterValue = $request->input('filter');

    // Get IDs of appointments with prescriptions
    $prescribedAppointmentIds = Prescription::where('doctor_id', $doctorId)->pluck('appointment_id')->toArray();

    // Fetching completed appointments (appointments with prescriptions)
    $completedAppointmentsQuery = Appointment::with('patient.user')
        ->where('doctor_id', $doctorId)
        ->whereIn('id', $prescribedAppointmentIds);

    // Fetching upcoming appointments (appointments without prescriptions)
    $upcomingAppointmentsQuery = Appointment::with('patient.user')
        ->where('doctor_id', $doctorId)
        ->whereNotIn('id', $prescribedAppointmentIds) // Exclude completed appointments
        ->where('date', '>=', today()) // Include only future appointments
        ->orderBy('date', 'asc');

    // Apply filters if specified
    if ($filterBy && $filterValue) {
        switch ($filterBy) {
            case 'name':
                $completedAppointmentsQuery->whereHas('patient.user', function ($query) use ($filterValue) {
                    $query->where('first_name', 'like', "%$filterValue%")
                          ->orWhere('last_name', 'like', "%$filterValue%");
                });

                $upcomingAppointmentsQuery->whereHas('patient.user', function ($query) use ($filterValue) {
                    $query->where('first_name', 'like', "%$filterValue%")
                          ->orWhere('last_name', 'like', "%$filterValue%");
                });
                break;

            case 'date':
                $completedAppointmentsQuery->where('date', 'like', "%$filterValue%");
                $upcomingAppointmentsQuery->where('date', 'like', "%$filterValue%");
                break;

                case 'comment':
                    $completedAppointmentsQuery->whereHas('prescriptions', function ($query) use ($filterValue) {
                        $query->where('comment', 'like', "%$filterValue%");
                    });
                
                    $upcomingAppointmentsQuery->whereHas('prescriptions', function ($query) use ($filterValue) {
                        $query->where('comment', 'like', "%$filterValue%");
                    });
                    break;
                
                case 'morning_med':
                    $completedAppointmentsQuery->whereHas('prescriptions', function ($query) use ($filterValue) {
                        $query->where('morning_med', 'like', "%$filterValue%");
                    });
                
                    $upcomingAppointmentsQuery->whereHas('prescriptions', function ($query) use ($filterValue) {
                        $query->where('morning_med', 'like', "%$filterValue%");
                    });
                    break;
                
                case 'afternoon_med':
                    $completedAppointmentsQuery->whereHas('prescriptions', function ($query) use ($filterValue) {
                        $query->where('afternoon_med', 'like', "%$filterValue%");
                    });
                
                    $upcomingAppointmentsQuery->whereHas('prescriptions', function ($query) use ($filterValue) {
                        $query->where('afternoon_med', 'like', "%$filterValue%");
                    });
                    break;
                
                case 'night_med':
                    $completedAppointmentsQuery->whereHas('prescriptions', function ($query) use ($filterValue) {
                        $query->where('night_med', 'like', "%$filterValue%");
                    });
                
                    $upcomingAppointmentsQuery->whereHas('prescriptions', function ($query) use ($filterValue) {
                        $query->where('night_med', 'like', "%$filterValue%");
                    });
                    break;

            default:
                break;
        }
    }

    $completedAppointments = $completedAppointmentsQuery->get();
    $upcomingAppointments = $upcomingAppointmentsQuery->get();

    // Fetch prescriptions for all appointments
    $prescriptions = Prescription::where('doctor_id', $doctorId)
        ->whereIn('appointment_id', $completedAppointments->pluck('id')->merge($upcomingAppointments->pluck('id')))
        ->get();

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