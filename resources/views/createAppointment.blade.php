<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Appointment</title>
    @vite(['resources/js/app.js'])
</head>
<body class="createAppointments">
    <h1>Create New Doctor's Appointment</h1>
    <form action="" method="POST">
        <label for="patient_id">Patient ID</label>
        <input type="number" id="patient_id" name="patient_id" required>

        <label for="patient_name">Patient Name</label>
        <input type="text" id="patient_name" name="patient_name" readonly>

        <label for="appointment_date">Date</label>
        <input type="datetime-local" id="appointment_date" name="appointment_date" required>

        <label for="doctor_id">Doctor</label>
        <select name="doctor_id" id="doctor_id" required>
            <option value="">Select a doctor</option>
        </select>

        <input type="submit" value="Create Appointment">
    </form>

</body>
</html>