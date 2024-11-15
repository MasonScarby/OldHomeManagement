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

        $accessLevel = $user->role->access_level;

        // Redirect based on access level
        switch ($accessLevel) {
            case 1:
                return redirect()->route('approval'); // Admin access
            case 2:
                return redirect()->route('approval'); // Supervisor access
            case 3:
                return redirect()->route('doctorHome');
            case 4:
                return redirect()->route('caregiverHome');
            case 5:
                return redirect()->route('patientHome');
            case 6:
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
