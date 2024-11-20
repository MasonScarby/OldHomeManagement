<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showRegisterForm()
    {
        $roles = \App\Models\Role::all(); 
        return view('register', compact('roles'));
    }

    public function index()
    {
        $users = User::with('role')->get();

        return response()->json(['data' => $users], 200);
    }

    public function store(Request $request)
{
    $rules = [
        'first_name' => 'required|string|max:20',
        'last_name' => 'required|string|max:20',
        'email' => 'required|string|email|max:30|unique:users',
        'password' => 'required|string|min:8|max:30',
        'phone' => 'required|string|max:15',
        'date_of_birth' => 'required|date',
        'role_id' => 'required|exists:roles,id',
    ];

    // Add validation for patient-specific fields if role is Patient
    if ($request->input('role_id') == 5) { // Assuming '5' is the ID for the Patient role
        $rules = array_merge($rules, [
            'family_code' => 'required|string|max:5',
            'emergency_contact' => 'required|string|max:15',
            'contact_relationship' => 'required|string|max:20',
        ]);
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Save the user
    $user = User::create([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'phone' => $request->input('phone'),
        'date_of_birth' => $request->input('date_of_birth'),
        'role_id' => $request->input('role_id'),
        'is_approved' => false,
    ]);

    // If the user is a patient, save to the patients table
    if ($user->role_id == 5) {
        Patient::create([
            'user_id' => $user->id,
            'family_code' => $request->input('family_code'),
            'emergency_contact' => $request->input('emergency_contact'),
            'contact_relationship' => $request->input('contact_relationship'),
            'group' => $request->input('group', ''),
            'admission_date' => $request->input('admission_date', now()),
        ]);
    }

    return redirect()->route('login');
}
}