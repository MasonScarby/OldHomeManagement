<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shire Homes</title>
    @vite(['resources/js/app.js'])
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
    
    </style>
</head>
<body>
    @include('navbar')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h1>Doctor's Home</h1>

    <div class="container">
        <!-- Search Form -->
        <form action="{{ route('doctorList') }}" method="GET">
            <label for="search_by">Search By:</label>
            <select name="search_by" id="search_by">
                <option value="name" {{ request()->input('search_by') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="admission_date" {{ request()->input('search_by') == 'admission_date' ? 'selected' : '' }}>Admission Date</option>
                <option value="comment" {{ request()->input('search_by') == 'comment' ? 'selected' : '' }}>Comment</option>
                <option value="age" {{ request()->input('search_by') == 'age' ? 'selected' : '' }}>Age</option>
            </select>
            <input type="text" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <button type="submit">Search</button>
            <a href="{{ route('doctorList') }}" class="btn-reset">Reset</a>
        </form>

        <!-- Patient Table -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Admission Date</th>
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
                        <td>{{ $patient->admission_date->format('m-d-Y') }}</td>
                        <td>{{ $patient->comments }}</td>
                        <td>{{ $patient->morning_med }}</td>
                        <td>{{ $patient->afternoon_med }}</td>
                        <td>{{ $patient->night_med }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Appointment Form -->
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

        <!-- upcoming  -->
        <h1>Upcoming Appointments</h1>
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('m-d-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
