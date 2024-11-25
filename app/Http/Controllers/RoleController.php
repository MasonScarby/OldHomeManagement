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
        $roles = Role::all(columns: ['role_name', 'access_level']);
        return view('roles', data: compact('roles'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'role_name' => 'required|string|max:50',
            'access_level' => 'required|integer',
        ]);

        $role = Role::create([
            'role_name' => $request->role_name,
            'access_level' => $request->access_level,
        ]);

        return redirect()->route('roles.index');    
    }
    public function create()
    {
        //
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
    public function showRoles(){
        $roles = Role::all(['role_name', 'access_level']);
        return view('roles', compact('roles'));
    }

}
