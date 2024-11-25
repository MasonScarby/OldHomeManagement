<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['user', 'role'])->get();
        return view('employees', compact('employees')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
$validateData = $request->validate([
    'user_id' => 'required|exists:users,id',
    'role_name' => 'required|exists:roles,id',
    'salary' => 'required|numeric|min:0'
]);
$employee = employees::create([
    'user_id' => $validatedData['user_id'],
    'role_name' => $validatedData['role_name'],
    'salary' => $validatedData['salary']
]);

return response()->json($employee,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
?>