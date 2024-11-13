<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return response()->json(['data' => $users], 201);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'role_id' => 'required|exists:roles,id', // Foreign key validation
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new user
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); // Hash the password
        $user->phone = $request->input('phone');
        $user->date_of_birth = $request->input('date_of_birth');
        $user->role_id = $request->input('role_id');
        $user->is_approved = false; // Defaults to false

        $user->save();

        $role = $user->role->role_name;

        if ($role == 'patient'){
            return view('patientInformation'); 
        } else {
            return view(view: 'login');
        }
    }
}

