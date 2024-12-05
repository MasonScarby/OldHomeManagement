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
    <div class='page-container'>
        <h1>Employees</h1>

        <!-- Search Form -->
        <form action="{{ route('employees.index') }}" method="GET" class="searchForm">
            <label for="search_by">Search By:</label>
            <select name="search_by" id="search_by">
                <option value="employee_id" {{ request()->input('search_by') == 'employee_id' ? 'selected' : '' }}>Emp ID</option>
                <option value="name" {{ request()->input('search_by') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="role" {{ request()->input('search_by') == 'role' ? 'selected' : '' }}>Role</option>
                <option value="salary" {{ request()->input('search_by') == 'salary' ? 'selected' : '' }}>Salary</option>
            </select>

            <input type="text" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <button type="submit">Search</button>
            <a href="{{ route('employees.index') }}" class="btn-reset">Reset</a>
        </form>

        <!-- Employee Table -->
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

        <div class="message-container">
            @if(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @elseif(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif
        </div>

        <!-- Salary Update Form -->
        @if(Auth::check() && Auth::user()->role && Auth::user()->role->access_level === 1)
            <div class="controls">
                <form action="{{ route('employees.updateSalary') }}" method="POST" class="salaryForm">
                    @csrf
                    @method('PUT')

                    <!-- Maintain search parameters in the form -->
                    <input type="hidden" name="search_by" value="{{ request()->input('search_by') }}">
                    <input type="hidden" name="search" value="{{ request()->input('search') }}">

                    <div>
                        <label for="employee_id" class="label">Emp ID</label>
                        <input type="number" name="employee_id" id="employee_id" placeholder="Enter ID" min="1" required>
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
    @include('footer')
</body>
</html>
