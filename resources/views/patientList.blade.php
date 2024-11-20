<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List</title>
    <!-- <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
        }
        label {
            font-weight: bold;
        }
        input {
            padding: 5px;
            width: 150px;
        }
        button {
            padding: 10px 20px;
            margin-top: 10px;
        }
    </style> -->
</head>
<body>
    <h1>Patient Page</h1>

       @if(isset($patients) && $patients->isEmpty())
            <p>No patients found.</p>
        @elseif(isset($patients))
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
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
                            <td>{{ $patient->user->first_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($patient->user->date_of_birth)->age }}</td>
                            <td>{{ $patient->emergency_contact }}</td>
                            <td>{{ $patient->contact_relationship }}</td>
                            <td>{{ $patient->admission_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
</body>
</html>
