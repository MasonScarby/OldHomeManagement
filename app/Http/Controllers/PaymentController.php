<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    
    public function paymentPage()
    {
        return view('payment');
    }

    public function fetchOrInsertPayment(Request $request)
    {
        $patientId = $request->patient_id;
    
        // Check if patient exists in patients table
        $patient = Patient::find($patientId);
    
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }
    
        // Check if payment exists for the patient
        $payment = Payment::where('patient_id', $patientId)->first();
    
        if ($payment) {
            // Return the updated total due (payment amount after adjustments)
            return response()->json([
                // 'admission_date' => $patient->admission_date,  // Return formatted admission date
                'total_due' => $payment->amount,  // Return updated total due from payment record
            ]);
        } else {
            // Calculate the initial total due based on the admission date
            $admissionDateCarbon = Carbon::parse($patient->admission_date);
            $currentDate = Carbon::now();
            $daysSinceAdmission = $admissionDateCarbon->diffInDays($currentDate);
    
            // Calculate total amount due ($10 per day, can be adjusted)
            $totalDue = $daysSinceAdmission * 10;
    
            // Get the count of prescriptions after the admission date (if needed)
            $prescriptionsCount = $patient->prescriptions()->count();
            $totalDue += $prescriptionsCount * 50;  // Adjust $50 per prescription
    
            // Insert a new record into the payments table
            Payment::create([
                'patient_id' => $patientId,
                'admission_date' => $patient->admission_date,
                'amount' => $totalDue,  // Set the calculated total due
                'payment_date' => Carbon::now(),
            ]);
    
            return response()->json([
                // 'admission_date' => $patient->admission_date,  // Return admission date
                'total_due' => $totalDue,  // Initial total due
            ]);
        }
    } 
            

    public function processPayment(Request $request)
    {
        $patientId = $request->patient_id;
        $paymentAmount = $request->payment_amount;
    
        // Validate payment amount
        if (!is_numeric($paymentAmount) || $paymentAmount <= 0) {
            return response()->json(['error' => 'Invalid payment amount'], 400);
        }
    
        // Check if patient exists
        $patient = Patient::find($patientId);
    
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }
    
        // Find the payment record for the patient
        $payment = Payment::where('patient_id', $patientId)->first();
    
        if ($payment) {
            // Calculate the remaining amount after the payment
            $remainingAmount = $payment->amount - $paymentAmount;
    
            // Ensure the remaining amount is not negative
            if ($remainingAmount < 0) {
                $remainingAmount = 0;
            }
    
            // Update the payment record with the remaining amount
            $payment->update([
                'amount' => $remainingAmount,
                'payment_date' => Carbon::now(),  // Update payment date to current date
            ]);
    
            // Return the remaining amount as total due (since it's updated in the table)
            return response()->json([
                'remaining_amount' => $remainingAmount,  // Return the remaining amount
                'total_due' => $remainingAmount,  // Return the updated total due
            ]);
        }
    
        return response()->json(['error' => 'Payment record not found'], 404);
    }
    
        

}
