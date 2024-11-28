<?php

namespace App\Http\Controllers;

use App\Models\PatientLog;
use App\Models\User;
use App\Models\Roster;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientLogsController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'caregiver_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'morning_med_status' => 'required|boolean',
            'afternoon_med_status' => 'required|boolean',
            'night_med_status' => 'required|boolean',
            'breakfast_status' => 'required|boolean',
            'lunch_status' => 'required|boolean',
            'dinner_status' => 'required|boolean',
        ]);

        // Check if a log already exists for this patient, caregiver, and date
        $log = PatientLog::updateOrCreate(
            [
                'patient_id' => $validatedData['patient_id'],
                'caregiver_id' => $validatedData['caregiver_id'],
                'date' => $validatedData['date'],
            ],
            $validatedData
        );

        return response()->json(['message' => 'Log saved successfully.', 'log' => $log]);
    }

    public function getLogByDate($patientId, $date)
    {
         // Fetch the patient based on the given patient ID
         $patient = Patient::where('id', $patientId)->first();

         // If patient not found, return error
         if (!$patient) {
             return response()->json(['error' => 'Patient not found'], 404);
         }
 
         // Fetch the patient's log for the given date
         $log = PatientLog::where('patient_id', $patient->id)
                         ->where('date', $date)
                         ->first();
 
         $doctor = null;
         $caregiver = null;
 
         // Fetch the roster for the given date to get the doctor
         $roster = Roster::where('date', $date)->first();
         if ($roster) {
             $doctor = User::find($roster->doctor); // Find the doctor based on the roster's doctor ID
         }
 
         // If log exists, fetch caregiver details
         if ($log) {
             $caregiver = User::find($log->caregiver_id); // Fetch caregiver from the user table
         }
 
         // Return the log data, doctor name, caregiver name, and other details
         return response()->json([
             'log' => $log ? [
                 'doctor_name' => $doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'No doctor assigned', // Doctor's full name
                 'caregiver_name' => $caregiver ? $caregiver->first_name . ' ' . $caregiver->last_name : 'No caregiver assigned', // Caregiver's full name
                 'morning_med_status' => $log->morning_med_status,
                 'afternoon_med_status' => $log->afternoon_med_status,
                 'night_med_status' => $log->night_med_status,
                 'breakfast_status' => $log->breakfast_status,
                 'lunch_status' => $log->lunch_status,
                 'dinner_status' => $log->dinner_status,
             ] : null
         ]);
    }

    public function getLogForFamily(Request $request)
{
    $validated = $request->validate([
        'date' => 'required|date',
        'familyCode' => 'required|string|max:5',
        'patientId' => 'required|exists:patients,id',
    ]);

    // Fetch the patient based on the ID and family code
    $patient = Patient::where('id', $validated['patientId'])
                      ->where('family_code', $validated['familyCode'])
                      ->first();

    if (!$patient) {
        return response()->json(['error' => 'Invalid patient ID or family code.'], 404);
    }

    // Fetch the patient's log for the given date
    $log = PatientLog::where('patient_id', $patient->id)
                     ->where('date', $validated['date'])
                     ->first();

    if (!$log) {
        return response()->json(['message' => 'No log data available for the selected date.'], 200);
    }

    // Fetch the roster for the given date to get the doctor
    $roster = Roster::where('date', $validated['date'])->first();
    $doctor = $roster ? User::find($roster->doctor) : null;

    // Fetch caregiver details
    $caregiver = $log ? User::find($log->caregiver_id) : null;

    // Prepare the response data
    return response()->json([
        'log' => [
            'doctor_name' => $doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'No doctor assigned',
            'caregiver_name' => $caregiver ? $caregiver->first_name . ' ' . $caregiver->last_name : 'No caregiver assigned',
            'morning_med_status' => $log->morning_med_status,
            'afternoon_med_status' => $log->afternoon_med_status,
            'night_med_status' => $log->night_med_status,
            'breakfast_status' => $log->breakfast_status,
            'lunch_status' => $log->lunch_status,
            'dinner_status' => $log->dinner_status,
        ],
    ]);
}
}