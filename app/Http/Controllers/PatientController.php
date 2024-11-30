<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    
    
    public function index()
    {
        $patients = Patient::with('user')->get();
        return response()->json(['data' => $patients], 201);
    }

    public function create()
    {
        return view('patient.create');
    }


    public function patientList(Request $request)
    {
        // Start with the query to get patients, eager load the 'user' relationship
        $query = Patient::with('user')
                        ->whereHas('user', function($query) {
                            $query->where('is_approved', true); // Only include approved users
                        });

        // Check if a search is performed
        if ($request->has('search') && $request->has('search_by')) {
            $search = $request->input('search');
            $searchBy = $request->input('search_by');

            // Apply filter based on the selected search field
            if ($searchBy == 'patient_id') {
                $query->where('id', 'like', "%$search%");
            } elseif ($searchBy == 'name') {
                $query->whereHas('user', function($query) use ($search) {
                    $query->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                });
            } elseif ($searchBy == 'emergency_contact') {
                $query->where('emergency_contact', 'like', "%$search%");
            } elseif ($searchBy == 'contact_relationship') {
                $query->where('contact_relationship', 'like', "%$search%");
            } elseif ($searchBy == 'admission_date') {
                $query->whereDate('admission_date', 'like', "%$search%");
            } elseif ($searchBy == 'age') {
                // Filter by age: assuming the search input is the age
                $age = (int) $search;
                $query->whereHas('user', function ($query) use ($age) {
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) = ?', [$age]);
                });
            }
        }

        // Execute the query and get the filtered results
        $patients = $query->get();

        return view('patientList', compact('patients'));
    }

<<<<<<< HEAD
=======


    public function showPatientAssignmentForm(Request $request)
    {
        return view('patientAssignment');
    }

    public function searchPatientById(Request $request)
    {
        $patientId = $request->input('patient_id');

        // Validate the input
        if (!$patientId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please enter a patient ID.',
            ]);
        }

        // Find the patient by ID
        $patient = Patient::with('user')->find($patientId);

        if (!$patient) {
            // If patient doesn't exist
            return response()->json([
                'status' => 'error',
                'message' => 'Patient ID does not exist.',
            ]);
        }

        if (!$patient->user->is_approved) {
            // If patient exists but is not approved
            return response()->json([
                'status' => 'error',
                'message' => 'Only approved patients can be assigned a group.',
            ]);
        }

        // If the patient exists and is approved, return success
        return response()->json([
            'status' => 'success',
            'first_name' => $patient->user->first_name,
            'last_name' => $patient->user->last_name,
        ]);
    }

    public function storePatientAssignment(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'patient_name' => 'required',
            'group' => 'required|in:A,B,C,D',            
            'admission_date' => 'required|date',
        ]);

        // Check if the patient exists
        $patient = Patient::with('user')->find($request->input('patient_id'));

        if (!$patient) {
            return redirect()->back()->withErrors(['patient_id' => 'Patient ID does not exist.']);
        }

        if (!$patient->user->is_approved) {
            // If the patient exists but is not approved
            return redirect()->back()->withErrors(['patient_id' => 'Only approved patients can be assigned a group.']);
        }

        // Update the patient record
        $patient->update([
            'group' => $request->input('group'),
            'admission_date' => $request->input('admission_date'),
        ]);

        // Redirect with a success message
        return redirect()->back()->with('status', 'Patient information updated successfully!');
    }

>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85
}
