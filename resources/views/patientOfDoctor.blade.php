<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Doctor Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        input, select, button {
            padding: 10px;
            font-size: 16px;
        }
        .btn-reset {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            color: #333;
        }
        .btn-reset:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    @include('navbar')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h1>Doctor's Dashboard</h1>

    <div class="container">
        <form action="{{ route('patientList') }}" method="GET">
            <label for="search_by">Search By:</label>
            <select name="search_by" id="search_by">
                <option value="patient_id" {{ request()->input('search_by') == 'patient_id' ? 'selected' : '' }}>Patient ID</option>
                <option value="name" {{ request()->input('search_by') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="emergency_contact" {{ request()->input('search_by') == 'emergency_contact' ? 'selected' : '' }}>Emergency Contact</option>
                <option value="contact_relationship" {{ request()->input('search_by') == 'contact_relationship' ? 'selected' : '' }}>Contact Relationship</option>
                <option value="admission_date" {{ request()->input('search_by') == 'admission_date' ? 'selected' : '' }}>Admission Date</option>
                <option value="age" {{ request()->input('search_by') == 'age' ? 'selected' : '' }}>Age</option>
            </select>
        
            <input type="text" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <button type="submit">Search</button>
            <a href="{{ route('patientList') }}" class="btn-reset">Reset</a>
        </form>

        <!-- Patient Table -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Comment</th>
                    <th>Morning Med</th>
                    <th>Afternoon Med</th>
                    <th>Night Med</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->user->first_name }} {{ $patient->user->last_name }}</td>
                        <td>{{ $patient->admission_date->format('Y-m-d') }}</td>
                        <td>{{ $patient->comments }}</td>
                        <td>{{ $patient->morning_med }}</td>
                        <td>{{ $patient->afternoon_med }}</td>
                        <td>{{ $patient->night_med }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>



<form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <label for="patient">Patient:</label>
            <select name="patient" id="patient">
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->user->first_name }} {{ $patient->user->last_name }}</option>
                @endforeach
            </select>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <button type="submit" style="background-color: green; color: white;">Submit</button>
        </form>