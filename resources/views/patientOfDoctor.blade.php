<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    @vite(['resources/js/app.js'])
    <style>
body {
    background-color: whitesmoke;
    font-family: Arial, sans-serif;
    color: #303030;
    margin: 0;
    padding: 0;
}

h1, h2 {
    text-align: center;
    color: #303030;
}

h1 {
    margin-top: 20px;
    font-size: 28px;
    border-bottom: 2px solid #E4C297;
    padding-bottom: 10px;
}

h2 {
    margin-top: 40px;
    font-size: 22px;
    border-bottom: 1px solid #E4C297;
    padding-bottom: 8px;
}


p {
    font-size: 16px;
    margin: 10px 20px;
    line-height: 1.5;
}

strong {
    color: #E4C297;
}


table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: whitesmoke;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

table th, table td {
    text-align: center;
    padding: 10px;
    border: 1px solid #E4C297;
}

table th {
    background-color: #E4C297;
    color: whitesmoke;
    font-weight: bold;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tbody tr:hover {
    background-color: #f0e5d4;
}


form {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    background-color: whitesmoke;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

form div {
    margin-bottom: 15px;
}

form label {
    font-weight: bold;
    color: #303030;
    display: block;
    margin-bottom: 5px;
}

form input[type="text"], 
form input[type="date"] {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #E4C297;
    border-radius: 4px;
    background-color: whitesmoke;
    color: #303030;
}

form input[type="text"]:focus,
form input[type="date"]:focus {
    outline: none;
    border-color: #d1a679;
    background-color: #f9f9f9;
}

form button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    background-color: #E4C297;
    color: whitesmoke;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #d1a679;
}


a {
    display: block;
    text-align: center;
    margin: 20px auto;
    padding: 10px 15px;
    width: 200px;
    font-size: 14px;
    color: whitesmoke;
    background-color: #303030;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color: #4a4a4a;
}


@media (max-width: 600px) {
    table {
        font-size: 12px;
    }

    form {
        padding: 15px;
    }

    form label {
        font-size: 14px;
    }

    form input[type="text"], form input[type="date"] {
        font-size: 12px;
    }

    form button {
        font-size: 14px;
    }

    a {
        font-size: 12px;
        width: 150px;
    }
}
    </style>
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
        <input type="hidden" name="appointment_id" value="{{ $appointment->id ?? '' }}" readonly>
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