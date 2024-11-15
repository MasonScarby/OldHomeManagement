<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

}
