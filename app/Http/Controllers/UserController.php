<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\supervisor;
use App\Models\doctor;
use App\Models\caregiver;
use Illuminate\Mail\Message;
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
}
