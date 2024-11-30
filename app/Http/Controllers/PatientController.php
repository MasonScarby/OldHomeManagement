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

}
