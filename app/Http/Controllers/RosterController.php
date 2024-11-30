<?php

namespace App\Http\Controllers;


use App\Models\Roster;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use App\Models\Patient
;
=======
use App\Models\Patient;
use Illuminate\Support\Facades\Log;
>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85


class RosterController extends Controller
{
<<<<<<< HEAD
    /**
     * Display a form for creating a new roster entry.
     */
   public function showRosterForm()
{
    // Get Supervisors
    $supervisors = User::join('roles', 'users.role_id', '=', 'roles.id') 
        ->where('roles.role_name', 'Supervisor')
        ->select('users.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
        ->get();

    // Get Doctors
    $doctors = User::join('roles', 'users.role_id', '=', 'roles.id') 
        ->where('roles.role_name', 'Doctor')
        ->select('users.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
        ->get();

    // Get Caregivers
    $caregivers = User::join('roles', 'users.role_id', '=', 'roles.id') 
        ->where('roles.role_name', 'Caregiver')
        ->select('users.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
        ->get();

    // Return the form view with necessary data
    return view('newRoster', compact('supervisors', 'doctors', 'caregivers'));
}


    /**
     * Display a listing of all roster entries.
     */
=======

>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85
    public function index()
    {
        // Fetch approved supervisors
        $supervisors = User::whereHas('role', function ($query) {
            $query->where('role_name', 'supervisor');
        })->where('is_approved', true)->get();

<<<<<<< HEAD
        return response()->json([
            'rosters' => $rosters
        ], 201); 
=======
        // Fetch approved doctors
        $doctors = User::whereHas('role', function ($query) {
            $query->where('role_name', 'doctor');
        })->where('is_approved', true)->get();

        // Fetch approved caregivers
        $caregivers = User::whereHas('role', function ($query) {
            $query->where('role_name', 'caregiver');
        })->where('is_approved', true)->get();

        // Pass data to the view
        return view('newRoster', compact('supervisors', 'doctors', 'caregivers'));
>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85
    }
    

   
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
<<<<<<< HEAD
            'supervisor_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'caregiver1_id' => 'required|exists:users,id',
            'caregiver2_id' => 'required|exists:users,id',
            'caregiver3_id' => 'required|exists:users,id',
            'caregiver4_id' => 'required|exists:users,id',
        ]);

        // If validation fails, return a response with validation errors
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 400);
        }

        // Create a new roster entry
        $roster = Roster::create([
            'date' => $request->date,
            'supervisor_id' => $request->supervisor_id,
            'doctor_id' => $request->doctor_id,
            'caregiver1_id' => $request->caregiver1_id,
            'caregiver2_id' => $request->caregiver2_id,
            'caregiver3_id' => $request->caregiver3_id,
            'caregiver4_id' => $request->caregiver4_id,
        ]);

        // Return success response
        return response()->json([
            'message' => 'Roster entry created successfully!',
            'roster' => $roster
        ], 201); // HTTP 201 for resource creation
    }
    
    /**
     * Display the specified roster entry.
     */
    public function show(Roster $roster)
    {
        return response()->json([
            'roster' => $roster
        ], 200);
=======
            'supervisor' => 'required|exists:users,id',
            'doctor' => 'required|exists:users,id',
            'caregiver1' => 'nullable|exists:users,id',
            'caregiver2' => 'nullable|exists:users,id',
            'caregiver3' => 'nullable|exists:users,id',
            'caregiver4' => 'nullable|exists:users,id',
        ]);
    
        Roster::create([
            'date' => $request->date,
            'supervisor' => $request->supervisor,
            'doctor' => $request->doctor,
            'caregiver1' => $request->caregiver1,
            'caregiver2' => $request->caregiver2,
            'caregiver3' => $request->caregiver3,
            'caregiver4' => $request->caregiver4,
        ]);
    
        return redirect()->back()->with('success', 'Roster created successfully!');
>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85
    }

    public function show(Request $request)
    {
        $date = $request->input('date');

        // Fetch rosters for the selected date
        $rosters = Roster::with(['supervisor', 'doctor', 'caregiver1', 'caregiver2', 'caregiver3', 'caregiver4'])
            ->whereDate('date', $date)
            ->get();

        return view('rosterList', compact('rosters', 'date'));
    }
        
    public function destroy(Roster $roster)
    {
        $roster->delete();

        return response()->json([
            'message' => 'Roster entry deleted successfully!'
        ], 200);
    }
<<<<<<< HEAD


    public function showRosterListForm()
    {
        $rosters = Roster::with([
           'user'
        ])->get();

        // Pass the rosters to the view
        return view('rosterList', compact('rosters'));
    }

    public function rosterList(Request $request)
    {
        $query = Roster::with([
            'supervisor', 'doctor', 'caregiver1', 'caregiver2', 'caregiver3', 'caregiver4'
        ]);

        // Filter by date if provided
        if ($request->has('date')) {
            $date = $request->input('date');
            $query->whereDate('date', $date);
        }

        $rosters = $query->get();
        return view('rosterList', compact('rosters'));
    }

}
=======
}
>>>>>>> 563e630463dddbbb43d52ef8c6eade0a97247e85
