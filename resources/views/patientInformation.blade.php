<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients Page</title>
</head>
<body>

    <h1>Patient Page</h1>


    <form action="{{ url('/patient') }}" method="POST">
        @csrf
        <div>
            <label for="user_id">User ID</label>
            <input type="text" name="user_id" id="user_id" required>
        </div>
       
        <div>
            <label for="family_code">Family Code</label>
            <input type="text" name="family_code" id="family_code" required>
        </div>
        <div>
            <label for="emergency_contact">Emergency Contact</label>
            <input type="text" name="emergency_contact" id="emergency_contact" required>
        </div>
        <div>
            <label for="contact_relationship">Relation to Emergency Contact</label>
            <input type="text" name="contact_relationship" id="contact_relationship" required>
        </div>
       
        <button type="submit">Register</button>
    </form> 
</body>
</html>
