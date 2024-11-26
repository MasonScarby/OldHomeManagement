<?php

namespace App\Http\Controllers;


use App\Models\Roster;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;


class RosterController extends Controller
{

    public function index()
    {
        // Fetch approved supervisors
        $supervisors = User::whereHas('role', function ($query) {
            $query->where('role_name', 'supervisor');
        })->where('is_approved', true)->get();

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
    }
    

   
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
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
}
