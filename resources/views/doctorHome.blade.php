<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shire Homes</title>
    @vite(['resources/js/app.js'])
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

        <form action="{{ route('appointment.filter') }}" method="GET">
            <label for="filter_by">Filter By:</label>
            <select name="filter_by" id="filter_by">
                <option value="name" {{ request()->input('filter_by') == 'name' ? 'selected' : '' }}>Patient Name</option>
                <option value="date" {{ request()->input('filter_by') == 'date' ? 'selected' : '' }}>Date</option>
                <option value="comment" {{ request()->input('filter_by') == 'comment' ? 'selected' : '' }}>Comment</option>
                <option value="morning_med" {{ request()->input('filter_by') == 'morning_med' ? 'selected' : '' }}>Morning Med</option>
                <option value="afternoon_med" {{ request()->input('filter_by') == 'afternoon_med' ? 'selected' : '' }}>Afternoon Med</option>
                <option value="night_med" {{ request()->input('filter_by') == 'night_med' ? 'selected' : '' }}>Night Med</option>
            </select>
            <input type="text" name="filter" placeholder="Search..." value="{{ request()->input('filter') }}">
            <button type="submit">Search</button>
            <a href="{{ route('appointment.filter') }}" class="btn-reset">Reset</a>
        </form>

        @if($completedAppointments->isEmpty())
            <div class="no-appointments">No completed appointments found.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Comment</th>
                        <th>Morning Med</th>
                        <th>Afternoon Med</th>
                        <th>Night Med</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedAppointments as $appointment)
                        @php
                            $prescription = $prescriptions->firstWhere('appointment_id', $appointment->id);
                        @endphp
                        <tr>
                            <td>{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('m-d-Y') }}</td>
                            <td>{{ $prescription->comment ?? $appointment->comment ?? 'No comment' }}</td>
                            <td>{{ $prescription->morning_med ?? 'N/A' }}</td>
                            <td>{{ $prescription->afternoon_med ?? 'N/A' }}</td>
                            <td>{{ $prescription->night_med ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <h1>Upcoming Appointments</h1>
        @if($upcomingAppointments->isEmpty())
            <div class="no-appointments">No upcoming appointments found.</div>
        @else
            <table>
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