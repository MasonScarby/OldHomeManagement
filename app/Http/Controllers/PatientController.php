<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function patientsPage()
    {
        return view('patientInformation');
    }
    
    public function index()
    {
        $patients = Patient::with('user')->get();
        return response()->json(['data' => $patients], 201);
    }

    public function create()
    {
        return view('patient.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'family_code' => 'required|string|max:5',
            'emergency_contact' => 'required|string',
            'contact_relationship' => 'required|string|max:20',
        ]);
        
        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        // Create a new patient instance
        $patient = new Patient();
        $patient->user_id = $request->input('user_id');
        $patient->family_code = $request->input('family_code');
        $patient->emergency_contact = $request->input('emergency_contact');
        $patient->contact_relationship = $request->input('contact_relationship');
        $patient->group = $request->input('group', '');  // Default null if not provided
        $patient->admission_date = $request->input('admission_date', now()); // Default null if not provided
        
        $patient->save();
        
        // Redirect to a different page or return a response
        return redirect()->route('login');  // Redirect after successful patient creation
    }
    
}
