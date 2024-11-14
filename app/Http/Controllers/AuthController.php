<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login
    public function login(Request $request)
{
    // Validate login credentials
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:8',
    ]);

    // Attempt login
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Check user role
        $user = Auth::user();

        if (!$user->is_approved) {
            // If the user is not approved, log them out and redirect with an error message
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account has not been approved yet.']);
        }

        $role = $user->role->role_name;

        // Redirect based on role
        switch ($role) {
            case 'admin':
                return redirect()->route('approval');
            case 'supervisor':
                return redirect()->route('approval');
            case 'doctor':
                return redirect()->route('doctorHome');
            case 'caregiver':
                return redirect()->route('caregiverHome');
            case 'patient':
                return redirect()->route('patientHome');
            case 'family member':
                return redirect()->route('family_memberHome');
            default:
                return redirect()->route('home');
        }
    }

    return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
}
    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
