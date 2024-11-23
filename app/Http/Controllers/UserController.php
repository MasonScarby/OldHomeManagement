<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\supervisor;
use App\Models\doctor;
use App\Models\caregiver;
use Illuminate\Mail\Message;
use App\Models\Role;
use App\Models\Patient;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function showRegisterForm()
    {
        $roles = \App\Models\Role::all(); 
        
        return view('user', compact('roles'));
    }

    public function index()
    {
        $users = User::with('role')->get();

        return response()->json(['data' => $users], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->date_of_birth = $request->input('date_of_birth');
        $user->role_id = $request->input('role_id');
        $user->is_approved = false;

        $user->save();

        $role = $user->role->role_name;
        
       // return response()->json(['message' => 'successful'], 201);
       if ($role === 'patient') {
        return view("patientInformation");
        } 
        elseif ($role === 'supervisor') {
            Supervisor::create([
                'user_id' => $user->id,
            ]);
            return response()->json(['message' => 'successful supervisor'], 201);
        } 
        elseif ($role === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
            ]);
            return response()->json(['message' => 'successful doctor'], 201);
        } 
        elseif ($role === 'caregiver') {
            Caregiver::create([
                'user_id' => $user->id,
            ]);
            return response()->json(['message' => 'successful caregiver'], 201);
        } 
        else {
            return response()->json(['message' => 'successful else'], 201);
            //UPDATE TO RETURN VIEWS
        }
    }
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

    $role = Role::find($request->input('role_id'));

    // Add validation for patient-specific fields if role is Patient
    if ($role && strtolower($role->role_name) === 'patient') { 
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
    if ($role && strtolower($role->role_name) === 'patient') {
        Patient::create([
            'user_id' => $user->id,
            'family_code' => $request->input('family_code'),
            'emergency_contact' => $request->input('emergency_contact'),
            'contact_relationship' => $request->input('contact_relationship'),
            'group' => $request->input('group', ''),
            'admission_date' => $request->input('admission_date', now()),
        ]);
    }

    if ($role && strtolower($role && in_array(strtolower($role->role_name), ['admin', 'supervisor', 'doctor', 'caregiver']))) { 
        $rules = array_merge($rules, [
            'salary' => 'numeric|min:0'
        ]);
    }


    if ($role && strtolower($role && in_array(strtolower($role->role_name), ['admin', 'supervisor', 'doctor', 'caregiver']))) {
        $employee = Employee::create([
        'user_id' => $user->id,
        'role_id' => $role->id,
        'salary' => $request->input('salary'),
        ]);
    }

    return redirect()->route('login');
}
