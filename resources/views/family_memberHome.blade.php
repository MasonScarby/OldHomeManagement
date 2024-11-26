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

    {{ __('You are logged in as family member!') }}

    <h1>Family Member's Home</h1>
    
    <form>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date"><br><br>

        <label for="familyCode">Family Code (For Patient Family Member):</label>
        <input type="text" id="familyCode" name="familyCode"><br><br>

        <label for="patientId">Patient ID (For Patient Family Member):</label>
        <input type="text" id="patientId" name="patientId"><br><br>
        <button type="submit">Ok</button>
        <button type="reset">Cancel</button>
        
        <br><br>
        <table border="1">
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
                    <td><input type="text" name="doctorName"></td>
                    <td><input type="text" name="appointment"></td>
                    <td><input type="text" name="caregiverName"></td>
                    <td><input type="text" name="morningMedicine"></td>
                    <td><input type="text" name="afternoonMedicine"></td>
                    <td><input type="text" name="nightMedicine"></td>
                    <td><input type="text" name="breakfast"></td>
                    <td><input type="text" name="lunch"></td>
                    <td><input type="text" name="dinner"></td>
                </tr>
            </tbody>
        </table>
    </form>
</body>
</html>