<?php

namespace App\Http\Controllers;


use App\Models\Roster;
use App\Models\User;
use App\Models\Role;
use App\Models\Supervisor;
use App\Models\Doctor;
use App\Models\Caregiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RosterController extends Controller
{
    /**
     * Display a form for creating a new roster entry.
     */
    public function showRosterForm()
    {
        $supervisors = Supervisor::join('users', 'supervisors.user_id', '=', 'users.id')
        ->where('users.is_approved', true)
        ->select('supervisors.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
        ->get();

    $doctors = Doctor::join('users', 'doctors.user_id', '=', 'users.id')
        ->where('users.is_approved', true)
        ->select('doctors.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
        ->get();

    $caregivers = Caregiver::join('users', 'caregivers.user_id', '=', 'users.id')
        ->where('users.is_approved', true)
        ->select('caregivers.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
        ->get();

        return view('newRoster', compact('supervisors','doctors','caregivers'));
    }

    /**
     * Display a listing of all roster entries.
     */
    public function index()
    {
        $rosters = Roster::all();

        return response()->json([
            'rosters' => $rosters
        ], 200); // Return JSON response with HTTP 200
    }

    /**
     * Store a newly created roster entry in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'supervisor_id' => 'required|integer|exists:users,id',
            'doctor_id' => 'required|integer|exists:users,id',
            'caregiver1' => 'required|integer|exists:users,id',
            'caregiver2' => 'required|integer|exists:users,id',
            'caregiver3' => 'required|integer|exists:users,id',
            'caregiver4' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 400);
        }

        // Create a new roster entry
        $roster = Roster::create($request->only([
            'date',
            'supervisor_id',
            'doctor_id',
            'caregiver1',
            'caregiver2',
            'caregiver3',
            'caregiver4',
        ]));


        
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
    // Eager load the related user data for supervisor, doctor, and caregivers
    $rosters = Roster::with([
        'supervisor', 'doctor', 'caregiver1', 'caregiver2', 'caregiver3', 'caregiver4'
    ])->get();

    // Pass the rosters to the view
    return view('rosterList', compact('rosters'));
}

    public function populateRosterListForm(Request $request)
    {
        $query = Roster::with(['supervisor', 'doctor', 'caregiver1', 'caregiver2', 'caregiver3', 'caregiver4']);

        if ($request->has('date') && $date = $request->input('date')) {
            $query->where('date', $date);
        }

    
        $rosters = $query->get();

        if ($rosters->isEmpty()) {
            return view('rosterList', compact('rosters'))->with('message', 'No roster data available for the selected date.');
        }
        return view('rosterList', compact('rosters'));
    }



}