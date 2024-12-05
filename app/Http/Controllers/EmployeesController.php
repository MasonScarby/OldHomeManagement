<?php 

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
   
    $query = Employee::with('user', 'role');

    
    if ($request->has('search') && $request->has('search_by')) {
        $search = $request->input('search');
        $searchBy = $request->input('search_by');

      
        if ($searchBy === 'employee_id') {
            $query->where('id', 'like', "%$search%");
        } elseif ($searchBy === 'name') {
            $query->whereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%");
            });
        } elseif ($searchBy === 'role') {
            $query->whereHas('role', function ($query) use ($search) {
                $query->where('role_name', 'like', "%$search%");
            });
        } elseif ($searchBy === 'salary') {
            $query->where('salary', 'like', "%$search%");
        }
    }

    
    $employees = $query->get();

    return view('employees', compact('employees'));
}


    /**
     * Store a newly created resource in storage.
     */
 


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
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
?>