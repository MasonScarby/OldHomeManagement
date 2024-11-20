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
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Salary</th>
        </tr>
        <!-- Dynamic employee data will be linked here -->
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