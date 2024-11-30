<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Roster List</title>
    @vite(['resources/js/app.js'])
</head>
<body class="patientList">
@include('navbar')

<h2>Roster List</h2>

<form method="GET" action="{{ route('rosterList') }}">
    <label for="date">Search By Date:</label>
    <input type="date" id="date" name="date">
    <button type="submit">Search</button>
</form>

@if($rosters->isEmpty())
    <p>No rosters found for the selected date.</p>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Roster ID</th>
            <th>Doctor</th>
            <th>Supervisor</th>
            <th>Caregiver1</th>
            <th>Caregiver2</th>
            <th>Caregiver3</th>
            <th>Caregiver4</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rosters as $roster)
            <tr>
                <td>{{ $roster->id }}</td>
                <td>{{ $roster->doctor_name ?: 'N/A' }}</td>
                <td>{{ $roster->supervisor_name ?: 'N/A' }}</td>
                <td>{{ $roster->caregiver1_name ?: 'N/A' }}</td>
                <td>{{ $roster->caregiver2_name ?: 'N/A' }}</td>
                <td>{{ $roster->caregiver3_name ?: 'N/A' }}</td>
                <td>{{ $roster->caregiver4_name ?: 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
