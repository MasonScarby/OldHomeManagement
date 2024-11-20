<?php

namespace App\Http\Controllers;


use App\Models\Roster;
use App\Models\User;
use App\Models\Role;
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
        $supervisors = User::join('roles', 'users.role_id', '=', 'roles.id') 
            ->where('roles.role_name', 'Supervisor')
            ->select('users.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
            ->get();

        $doctors = User::join('roles', 'users.role_id', '=', 'roles.id') 
            ->where('roles.role_name', 'Doctor')
            ->select('users.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
            ->get();

        $caregivers = User::join('roles', 'users.role_id', '=', 'roles.id') 
            ->where('roles.role_name', 'Caregiver')
            ->select('users.id', DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"))
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
            'supervisor' => 'required|string|max:255',
            'doctor' => 'required|string|max:255',
            'caregiver1' => 'required|string|max:255',
            'caregiver2' => 'required|string|max:255',
            'caregiver3' => 'required|string|max:255',
            'caregiver4' => 'required|string|max:255',
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
            'supervisor',
            'doctor',
            'caregiver1',
            'caregiver2',
            'caregiver3',
            'caregiver4'
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
     * Update the specified roster entry in storage.
     */
    public function update(Request $request, Roster $roster)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'sometimes|required|date',
            'supervisor' => 'sometimes|required|string|max:255',
            'doctor' => 'sometimes|required|string|max:255',
            'caregiver1' => 'sometimes|required|string|max:255',
            'caregiver2' => 'sometimes|required|string|max:255',
            'caregiver3' => 'sometimes|required|string|max:255',
            'caregiver4' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 400);
        }

        $roster->update($request->only([
            'date',
            'supervisor',
            'doctor',
            'caregiver1',
            'caregiver2',
            'caregiver3',
            'caregiver4'
        ]));

        return response()->json([
            'message' => 'Roster entry updated successfully!',
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
}
