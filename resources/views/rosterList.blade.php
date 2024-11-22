<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregiver Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        .form-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .form-header label {
            font-weight: bold;
            margin-right: 10px;
        }
        .form-header input[type="date"] {
            padding: 5px;
        }
        .table-container {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ccc;
        }
        .table-container th,
        .table-container td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
        }
        .table-container th {
            background-color: #0056b3;
            color: white;
            font-weight: bold;
        }
        .name-row td {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        .group-row td {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Roster List</h1>
    <div class="container">
        <!-- Form Header -->
        <form action="{{ url('/populateRosterListForm') }}" method="POST">
            @csrf
            <div class="form-header">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="{{ old('date') }}">
            </div>
            <button type="submit">Populate Table</button>
        </form> 
        
        <table class="table-container">
            <thead>
                <tr>
                    <th></th>
                    <th>Supervisor</th>
                    <th>Doctor</th>
                    <th>Caregiver1</th>
                    <th>Caregiver2</th>
                    <th>Caregiver3</th>
                    <th>Caregiver4</th>
                </tr>
            </thead>
            <tbody>
                @if($rosters && $rosters instanceof \Illuminate\Database\Eloquent\Collection)
                    @foreach($rosters as $roster)
                        <tr>
                            <td>Name</td>
                            <td>{{ $roster->supervisor->first_name }} {{ $roster->supervisor->last_name }}</td>
                            <td>{{ $roster->doctor->first_name }} {{ $roster->doctor->last_name }}</td>
                            <td>{{ $roster->caregiver1->first_name }} {{ $roster->caregiver1->last_name }}</td>
                            <td>{{ $roster->caregiver2->first_name }} {{ $roster->caregiver2->last_name }}</td>
                            <td>{{ $roster->caregiver3->first_name }} {{ $roster->caregiver3->last_name }}</td>
                            <td>{{ $roster->caregiver4->first_name }} {{ $roster->caregiver4->last_name }}</td>
                        </tr>        
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
