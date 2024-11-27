<?php

namespace App\Http\Controllers;

use App\Models\PatientLog;
use Illuminate\Http\Request;

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
}