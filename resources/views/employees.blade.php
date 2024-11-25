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
    <h2>Employee</h2>

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
        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
        <td>{{ $employee->role->role_name }}</td> 
        <td>{{ $employee->salary }}</td>
    </tr>
    @endforeach
    </table>

    <div class="controls">
        <button class="button-label">Emp ID</button>
        <input type="text" placeholder="Enter ID">
        <button class="button-label">New Salary</button>
        <input type="text" placeholder="Enter Salary">
    </div>

    <div class="controls">
        <button class="ok-btn">Ok</button>
        <button class="cancel-btn">Cancel</button>
    </div>
</div>
</body>
</html>