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

        if (!$date) {
            return view('rosterList', ['rosters' => null, 'date' => null]);
        }

        // Fetch the roster for the given date
        $roster = Roster::where('date', $date)->first();

        if (!$roster) {
            return view('rosterList', ['rosters' => null, 'date' => $date]);
        }

        // Fetch related user details for each role
        $supervisor = $roster->supervisor ? User::find($roster->supervisor) : null;
        $doctor = $roster->doctor ? User::find($roster->doctor) : null;
        $caregiver1 = $roster->caregiver1 ? User::find($roster->caregiver1) : null;
        $caregiver2 = $roster->caregiver2 ? User::find($roster->caregiver2) : null;
        $caregiver3 = $roster->caregiver3 ? User::find($roster->caregiver3) : null;
        $caregiver4 = $roster->caregiver4 ? User::find($roster->caregiver4) : null;

        // Prepare data for the view
        $rosters = [
            [
                'date' => $roster->date,
                'supervisor' => $supervisor ? $supervisor->first_name . ' ' . $supervisor->last_name : 'No supervisor assigned',
                'doctor' => $doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'No doctor assigned',
                'caregiver1' => $caregiver1 ? $caregiver1->first_name . ' ' . $caregiver1->last_name : 'No caregiver assigned',
                'caregiver2' => $caregiver2 ? $caregiver2->first_name . ' ' . $caregiver2->last_name : 'No caregiver assigned',
                'caregiver3' => $caregiver3 ? $caregiver3->first_name . ' ' . $caregiver3->last_name : 'No caregiver assigned',
                'caregiver4' => $caregiver4 ? $caregiver4->first_name . ' ' . $caregiver4->last_name : 'No caregiver assigned',
            ],
        ];

        return view('rosterList', ['rosters' => $rosters, 'date' => $date]);
    }
        
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

