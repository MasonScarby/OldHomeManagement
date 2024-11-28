<?php

namespace App\Http\Controllers;

use App\Models\PatientLog;
use App\Models\Roster;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index()
    {
        // Render the admin report page
        return view('adminReport');
    }

    public function searchMissedActivity(Request $request)
{
    $request->validate([
        'date' => 'required|date',
    ]);

    // Get the date from the request
    $date = $request->input('date');

    // Query for the roster for the given date to get the doctor
    $roster = Roster::where('date', $date)->first();

    $doctor = null;
    if ($roster) {
        // Fetch the doctor associated with the roster for the given date
        $doctor = User::find($roster->doctor);
    }

    // Query for patient logs with any missed activities
    $missedLogs = PatientLog::where('date', $date)
        ->where(function ($query) {
            $query->where('morning_med_status', false)
                  ->orWhere('afternoon_med_status', false)
                  ->orWhere('night_med_status', false)
                  ->orWhere('breakfast_status', false)
                  ->orWhere('lunch_status', false)
                  ->orWhere('dinner_status', false);
        })
        ->with(['patient.user', 'caregiver'])
        ->get();

    // Attach the doctor information to each log entry
    $missedLogs->each(function ($log) use ($doctor) {
        if ($doctor) {
            $log->doctor = $doctor; // Add doctor to the log
        }
    });

    return response()->json([
        'missedLogs' => $missedLogs,
    ]);
}

}
