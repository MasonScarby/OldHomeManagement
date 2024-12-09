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
    background-color: whitesmoke;
    font-family: Arial, sans-serif;
    color: #303030;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: whitesmoke;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}


h1, h3 {
    color: #303030;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
}

h1 {
    border-bottom: 2px solid #E4C297;
    padding-bottom: 10px;
}

h3 {
    margin-top: 40px;
}


.form {
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.form label {
    font-weight: bold;
    color: #303030;
}

.form select, 
.form input[type="text"] {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #E4C297;
    border-radius: 4px;
}

.form button,
.form .btn-reset {
    padding: 8px 15px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    background-color: #E4C297;
    color: whitesmoke;
    cursor: pointer;
    text-decoration: none;
}

.form button:hover,
.form .btn-reset:hover {
    background-color: #d1a679;
}

.form .btn-reset {
    background-color: #303030;
}


table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table thead th {
    background-color: #303030;
    color: whitesmoke;
    padding: 10px;
    text-align: left;
    font-size: 14px;
    border: 1px solid #E4C297;
}

table tbody td {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #E4C297;
}

table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

table tbody tr:nth-child(even) {
    background-color: #EDEDED;
}

table tbody tr:hover {
    background-color: #E4C297;
    color: whitesmoke;
}

table tbody td button {
    padding: 5px 10px;
    font-size: 12px;
    background-color: #303030;
    color: whitesmoke;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

table tbody td button:hover {
    background-color: #E4C297;
    color: whitesmoke;
}


.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #E4C297;
    border-radius: 4px;
    background-color: #EDEDED;
    color: #303030;
}

.alert.alert-success {
    background-color: #E4C297;
    color: whitesmoke;
}


.no-appointments {
    text-align: center;
    color: #303030;
    font-size: 16px;
    padding: 20px;
    border: 1px dashed #E4C297;
    border-radius: 4px;
    background-color: whitesmoke;
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

    <div class="container">
        <h1>Completed Appointments</h1>
        <form action="{{ route('doctorList') }}" method="GET" class='form'>
            <label for="filter_by">Filter By:</label>
            <select name="filter_by" id="filter_by">
                <option value="name" {{ request()->input('filter_by') == 'name' ? 'selected' : '' }}>Patient Name</option>
                <option value="date" {{ request()->input('filter_by') == 'date' ? 'selected' : '' }}>Date</option>
                <option value="comment" {{ request()->input('filter_by') == 'comment' ? 'selected' : '' }}>Comment</option>
                <option value="morning_med" {{ request()->input('filter_by') == 'morning_med' ? 'selected' : '' }}>Morning Medication</option>
                <option value="afternoon_med" {{ request()->input('filter_by') == 'afternoon_med' ? 'selected' : '' }}>Afternoon Medication</option>
                <option value="night_med" {{ request()->input('filter_by') == 'night_med' ? 'selected' : '' }}>Night Medication</option>
            </select>
            <input type="text" name="filter" placeholder="Search..." value="{{ request()->input('filter') }}">
            <button type="submit">Filter</button>
            <a href="{{ route('doctorList') }}" class="btn-reset">Reset</a>
        </form>

        @if($completedAppointments->isEmpty())
            <div class="no-appointments">No completed appointments found.</div>
        @else
            <h3>Completed Appointments and Prescriptions</h3>
            <table>
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Morning Med</th>
                        <th>Afternoon Med</th>
                        <th>Night Med</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedAppointments as $appointment)
                        @php
                            // Fetch prescription for the current appointment
                            $prescription = $prescriptions->firstWhere('appointment_id', $appointment->id);
                        @endphp
                        <tr>
                            <td>{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('m-d-Y') }}</td>
                            <td>{{ $prescription->morning_med ?? 'N/A' }}</td>
                            <td>{{ $prescription->afternoon_med ?? 'N/A' }}</td>
                            <td>{{ $prescription->night_med ?? 'N/A' }}</td>
                            <td>{{ $prescription->comment ?? $appointment->comment ?? 'No comment' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <h1>Upcoming Appointments</h1>
        @if($upcomingAppointments->isEmpty())
            <div class="no-appointments">No upcoming appointments found.</div>
        @else
            <table class='form'>
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Appointment Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($upcomingAppointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('m-d-Y') }}</td>
                            <td>
                                <!-- Pass both patient_id and appointment_id -->
                                <a href="{{ route('patientOfDoctor', ['patientId' => $appointment->patient_id, 'appointmentId' => $appointment->id]) }}">
                                    <button>View</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    
    @include('footer')
</body>
</html>
