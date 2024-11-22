<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patient List</title>
    @vite(['resources/js/app.js'])
</head>
<body class="patientList">

    @include('navbar')
    
    <div class="container">
        <h1>Patient List</h1>


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


        <table class="table">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Emergency Contact</th>
                    <th>Contact Relationship</th>
                    <th>Admission Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->user->first_name }} {{ $patient->user->last_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($patient->user->date_of_birth)->age }}</td>                        
                        <td>{{ $patient->emergency_contact }}</td>
                        <td>{{ $patient->contact_relationship }}</td>
                        <td>{{ $patient->admission_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>