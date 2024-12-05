<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
</head>
<body>
    @include('navbar')

    <h1>Patient Details</h1>
    <p><strong>First Name:</strong> {{ $patient->user->first_name }}</p>
    <p><strong>Last Name:</strong> {{ $patient->user->last_name }}</p>

    <h2>Previous Prescriptions</h2>
    @if($prescriptions->isEmpty())
        <p>No previous prescriptions found for this patient.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Morning Medication</th>
                    <th>Afternoon Medication</th>
                    <th>Night Medication</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescriptions as $prescription)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($prescription->created_at)->format('m-d-Y') }}</td>
                        <td>{{ $prescription->morning_med }}</td>
                        <td>{{ $prescription->afternoon_med }}</td>
                        <td>{{ $prescription->night_med }}</td>
                        <td>{{ $prescription->comment ?? 'No comment' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    <h2>Create Prescription</h2>
    <form action="{{ route('prescription.store') }}" method="POST">
        @csrf
        <input type="blocked" name="appointment_id" value="{{ $appointment->id ?? '' }}" readonly>
        <input type="hidden" name="doctor_id" value="{{ auth()->user()->id }}" readonly>
        <input type="hidden" name="patient_id" value="{{ $patient->id }}" readonly>

        <!-- Prescription Fields -->
        <div>
            <label for="morning_med">Morning Medication:</label>
            <input type="text" name="morning_med" id="morning_med" required>
        </div>

        <div>
            <label for="afternoon_med">Afternoon Medication:</label>
            <input type="text" name="afternoon_med" id="afternoon_med" required>
        </div>

        <div>
            <label for="night_med">Night Medication:</label>
            <input type="text" name="night_med" id="night_med" required>
        </div>

        <div>
            <label for="comment">Comment:</label>
            <input type="text" name="comment" id="comment" rows="4"></input>
        </div>

        <div>
            <label for="date" style="display:none;">Prescription Date:</label>
            <input type="date" name="date" id="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required style="display:none;">
        </div>

        <button type="submit">Create Prescription</button>
    </form>


    <a href="{{ route('doctorList') }}">Back to Dashboard</a>
</body>
</html>
