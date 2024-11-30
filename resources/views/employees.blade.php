<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    @vite(['resources/js/app.js'])
</head>
<body class="employees">
    @include('navbar')
    
<div class="container">
    <h2>Employees</h2>

    <table class="employee-table">
    <tr>
        <th>Emp ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Salary</th>
    </tr>
    @foreach($employees as $employee)
    <tr>
        <td>{{ $employee->id }}</td>
        <td>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</td> 
        <td>{{ $employee->role->role_name }}</td>
        <td>{{ $employee->salary }}</td>
    </tr>
    @endforeach
    </table>

    @if(Auth::check() && Auth::user()->role && Auth::user()->role->access_level === 1)
        <div class="controls">
            <form action="{{ route('employees.updateSalary') }}" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label for="employee_id" class="label">Emp ID</label>
                    <input type="number" name="employee_id" id="employee_id" placeholder="Enter ID" required>
                </div>
                <div>
                    <label for="new_salary" class="label">New Salary</label>
                    <input type="number" name="new_salary" id="new_salary" placeholder="Enter Salary" step="0.01" min="0" required>
                </div>
                <div>
                    <button type="submit" class="ok-btn">Ok</button>
                    <button type="reset" class="cancel-btn">Cancel</button>
    
                </div>
            </form>
        </div>
    @endif
</div>
</body>
</html>