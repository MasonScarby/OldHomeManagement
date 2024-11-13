<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json(['data' => $roles], 200);
    }

    // Create a new role
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'role_name' => 'required|string|max:50',
            'access_level' => 'required|integer',
        ]);

        // Create a new role and store it in the database
        $role = Role::create([
            'role_name' => $request->role_name,
            'access_level' => $request->access_level,
        ]);

        // Return a success message with the created role
        return response()->json(['message' => 'Role created successfully', 'data' => $role], 201);
    }
    public function create()
    {
        // Retrieve all roles to display in the dropdown
        $roles = Role::all();
        
        return view('register', compact('roles'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
