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
    $validated = $request->validate([
        'role_id' => 'required|exists:roles,id',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
        'phone' => 'required|string|max:15',
        'date_of_birth' => 'required|date',
        'is_approved' => 'nullable|boolean',
    ]);

    // Hash the password before creating the user
    $validated['password'] = Hash::make($validated['password']);

    try {
        \Log::info('Attempting to create user', $validated);
        $user = User::create($validated);
        \Log::info('User created successfully', ['user_id' => $user->id]);

        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    } catch (\Exception $e) {
        \Log::error('User creation failed', ['error' => $e->getMessage()]);

        return response()->json(['error' => 'User creation failed', 'message' => $e->getMessage()], 500);
    }
}

}
