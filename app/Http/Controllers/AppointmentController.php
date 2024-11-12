<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    

    public function index()
    {
        $appointments = Appointment::all();

        return response()->json([
            'success' => true,
            'data' => $appointments
        ]);
    }



    public function store(Request $request)
    {
        $appointments = appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date' => $request->date
        ]);
        
            return response()->json([
                'success'=> true,
                'message' => 'Appointment created successfully',
                'data'=> $appointments
            ], 201);
    }

}
