<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;

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
    return view('caregiverHome');
}

public function patientHome()
{
    return view('patientHome');
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
