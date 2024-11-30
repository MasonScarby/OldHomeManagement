<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaymentController extends Controller
{

     public function paymentPage()
     {
        //  $payments = payment::all();
         return view('payment');
     }
 
     
    public function index()
    {
        $payments = payment::all();
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors(),
            ], 400);
        }

        $userId = $request->user_id;
        $lastPaymentDate = Carbon::parse($request->last_payment_date);
        $currentDate = Carbon::now();

        $daysSinceLastPayment = $currentDate->diffInDays($lastPaymentDate);
        $totalDue = $daysSinceLastPayment * 10;

        // Count the number of appointments from the current date to the last payment date
        $appointmentCount = Appointment::where('patient_id', $userId)
            ->whereDate('appointment_date', '>=', $lastPaymentDate)
            ->whereDate('appointment_date', '<=', $currentDate)
            ->count();

        // Add appointment cost to the total due (assuming $10 per appointment, adjust as necessary)
        $totalDue += $appointmentCount * 50;

        // Create the payment record
        $payment = Payment::create([
            'user_id' => $userId,
            'last_payment_date' => $request->last_payment_date,
            'total_due' => $totalDue,
        ]);

        return response()->json([
            'message' => 'Payment record created successfully!',
            'payment' => $payment,
        ], 201);
    }

    public function pay(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'new_payment' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors(),
            ], 400);
        }

        $userId = $request->user_id;
        $newPayment = $request->new_payment;

        // Retrieve the latest payment for the user
        $payment = Payment::where('user_id', $userId)->latest()->first();

        if (!$payment) {
            return response()->json([
                'error' => 'No payment record found for the user.',
            ], 404);
        }

        $newTotalDue = $payment->total_due - $newPayment;

        $payment->update([
            'total_due' => $newTotalDue,
            'last_payment_date' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Payment processed successfully!',
            'payment' => $payment,
        ], 200);
    }
    public function calculateTotalDue(Request $request)
    {
        $userId = $request->input('user_id');
    
        $lastPayment = Payment::where('user_id', $userId)->latest()->first();
    
        if (!$lastPayment) {
            return response()->json(['error' => 'No payment record found for this user.'], 404);
        }
    
        $lastPaymentDate = Carbon::parse($lastPayment->last_payment_date);
        $currentDate = Carbon::now();
    
        $daysSinceLastPayment = $currentDate->diffInDays($lastPaymentDate);
    
        $totalDue = $daysSinceLastPayment * 5;
    
        // Count the number of appointments from the current date to the last payment date
        $appointmentCount = Appointment::where('patient_id', $userId)
            ->whereDate('appointment_date', '>=', $lastPaymentDate)
            ->whereDate('appointment_date', '<=', $currentDate)
            ->count();
    
        $totalDue += $appointmentCount * 10;
    
        return response()->json(['total_due' => $totalDue]);
    }
    
}
