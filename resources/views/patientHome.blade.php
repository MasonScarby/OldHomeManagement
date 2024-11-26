<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    @include('navbar')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{ __('You are logged in as patient!') }}
    <div class="form-group">
            <label for="patient-id">Patient ID</label>
            <input type="text" id="patient-id" name="patient-id">
        </div>

        <div class="form-group">
            <label for="patient-name">Patient Name</label>
            <input type="text" id="patient-name" name="patient-name">
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Doctor's Name</th>
                    <th>Doctor's Appointment</th>
                    <th>Caregiver's Name</th>
                    <th>Morning Medicine</th>
                    <th>Afternoon Medicine</th>
                    <th>Night Medicine</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="doctor-name"></td>
                    <td><input type="text" name="doctor-appointment"></td>
                    <td><input type="text" name="caregiver-name"></td>
                    <td><input type="text" name="morning-medicine"></td>
                    <td><input type="text" name="afternoon-medicine"></td>
                    <td><input type="text" name="night-medicine"></td>
                    <td><input type="text" name="breakfast"></td>
                    <td><input type="text" name="lunch"></td>
                    <td><input type="text" name="dinner"></td>
                </tr>
            </tbody>
        </table>
    </div>
    
</body>
</html>