<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use App\Models\Roster;
use App\Models\PatientLog;

class DashboardController extends Controller
{
    public function approval()
{
    $unapprovedUsers = User::where('is_approved', false)->get();

    return view('approval', compact('unapprovedUsers'));
}

public function approveUsers(Request $request)
    {
        // Get the array of approvals from the form submission
        $approvals = $request->input('approval');

        if (!$approvals) {
            return redirect()->route('approval')->with('error', 'No users selected for approval.');
        }

        // Loop through each user in the approval list
        foreach ($approvals as $userId => $approval) {
            $user = User::find($userId);
            if ($user) {
                if (isset($approval['yes']) && $approval['yes'] === 'on') {
                    // Approve the user
                    $user->is_approved = true;
                    $user->save();
                } elseif (isset($approval['no']) && $approval['no'] === 'on') {
                    // Delete the user if "No" was selected
                    $user->delete();
                }
            }
        }

        return redirect()->route('approval')->with('status', 'User approvals updated successfully!');
    }



public function approvalPage()
{
    return view('approval');
}

public function doctorHome()
{
    return view('doctorHome');
}

public function caregiverHome()
{
    $user = Auth::user(); // Get the logged-in caregiver
    $date = now()->toDateString(); // Today's date

    // Find today's roster
    $roster = Roster::whereDate('date', $date)->first();

    if (!$roster) {
        $patients = collect(); // Empty collection if no roster found
    } else {
        // Determine the caregiver's group
        $group = null;
        if ($roster->caregiver1 === $user->id) {
            $group = 'A';
        } elseif ($roster->caregiver2 === $user->id) {
            $group = 'B';
        } elseif ($roster->caregiver3 === $user->id) {
            $group = 'C';
        } elseif ($roster->caregiver4 === $user->id) {
            $group = 'D';
        }

        // Query patients for the caregiver's group
        $patients = $group ? Patient::with(['user', 'logs' => function ($query) use ($user, $date) {
            $query->where('caregiver_id', $user->id)->whereDate('date', $date);
        }])->where('group', $group)->get() : collect();
    }

    // Pass data to view
    return view('caregiverHome', compact('patients', 'date'));
}


public function patientHome()
{
    $user = Auth::user(); // Get the logged-in patient
    $date = now()->toDateString(); // Today's date

    // Fetch the patient's information from the patients table
    $patient = Patient::where('user_id', $user->id)->first(); // Assuming 'user_id' links to the 'users' table

    // Fetch the patient's log data for today, if it exists
    $log = PatientLog::where('patient_id', $patient->id)
                    ->where('date', $date)
                    ->first();

    $doctor = null;
    $roster = Roster::where('date', $date)
                    ->first(); // Get the roster for the given date
    if ($roster) {
        // Check if the doctor exists in the roster
        $doctor = User::find($roster->doctor); // Fetch the doctor's user information
    }

    $caregiver = null;
    if ($log) {
        // Fetch caregiver details from the users table
        $caregiver = User::find($log->caregiver_id);
    }

    // Pass data to the view
    return view('patientHome', compact('log', 'date', 'user', 'patient', 'doctor', 'caregiver'));
}

public function familyMemberHome()
{
    return view('family_memberHome');
}
}