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



public function showPatientAssignmentForm(Request $request)
    {
        return view('patientAssignment');
    }

    public function searchPatientById(Request $request)
{
    $patientId = $request->input('patient_id');
    
    // Validate patient_id input
    if (!$patientId) {
        return response()->json([
            'status' => 'error',
            'message' => 'Please enter a valid patient ID.',
        ]);
    }

    // Find the patient by ID
    $patient = Patient::find($patientId);

    if ($patient) {
        // Return first name and last name from the related User model
        return response()->json([
            'status' => 'success',
            'first_name' => $patient->user->first_name,
            'last_name' => $patient->user->last_name,
        ]);
    }

    // Return error response if patient not found
    return response()->json([
        'status' => 'error',
        'message' => 'Patient id does not exist.',
    ]);
}
    public function storePatientAssignment(Request $request)
    {
        // Validate the form submission
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'group' => 'required|max:1',
            'admission_date' => 'required|date',
        ]);

        // Find the patient by ID
        $patient = Patient::find($request->input('patient_id'));

        if (!$patient) {
            // If patient doesn't exist, return to the same page with an error message
            return redirect()->route('patient.assignment')
                             ->withErrors(['patient_id' => 'Patient ID does not exist.'])
                             ->withInput();
        }
    

        // Update only the group and admission_date fields
        $patient->update([
            'group' => $request->input('group'),
            'admission_date' => $request->input('admission_date'),
        ]);

        // Redirect with a success message
        return redirect()->route('patient.assignment')->with('status', 'Patient information updated successfully!');
    }

}
