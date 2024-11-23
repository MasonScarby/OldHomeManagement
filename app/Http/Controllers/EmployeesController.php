<?php

namespace App\Http\Controllers;
use App\Models\Employee;
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

    public function updateSalary(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id', 
            'new_salary' => 'required|numeric|min:0',
        ]);
    
        $employee = Employee::findOrFail($validated['employee_id']);
        $employee->salary = $validated['new_salary'];
        $employee->save();
    
        return redirect()->back()->with('success', 'Salary updated successfully.');
    }    
}

?>