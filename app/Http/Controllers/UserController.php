<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        // Retrieve all users with their role relationship
        $users = User::with('role')->get();

        return response()->json(['data' => $users], 200);
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
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->date_of_birth = $request->input('date_of_birth');
        $user->role_id = $request->input('role_id');
        $user->is_approved = false; 

        $user->save();

        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }
}
