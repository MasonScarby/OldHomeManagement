<?php

namespace App\Http\Controllers;


use App\Models\Roster;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Patient
;


class RosterController extends Controller
{
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
    public function index()
    {
        $rosters = Roster::all();

        return response()->json([
            'rosters' => $rosters
        ], 201); 
    }

    /**
     * Store a newly created roster entry in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
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
    }

    /**
     * Remove the specified roster entry from storage.
     */
    public function destroy(Roster $roster)
    {
        $roster->delete();

        return response()->json([
            'message' => 'Roster entry deleted successfully!'
        ], 200);
    }


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
