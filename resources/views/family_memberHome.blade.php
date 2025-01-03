<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shire Homes</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
</head>
<body class=family_memberHome>
    @include('navbar')
    <div class='page-container'>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    <h1>Family Member's Home</h1>
    
    <form id="logForm" class=form>
        @csrf
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
    
        <label for="familyCode">Family Code:</label>
        <input type="text" id="familyCode" name="familyCode" maxlength="5" required><br><br>
    
        <label for="patientId">Patient ID:</label>
        <input type="number" id="patientId" name="patientId" required><br><br>
    
        <button type="submit">Ok</button>
        <button type="reset" onclick="resetForm()" class="cancel">Cancel</button>
    </form>
    
    <div id="errorMessage" style="color: red;"></div>
    
    <table id="logTable" style="display: none;">
        <thead>
            <tr>
                <th>Patient's Name</th>
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
                <td id="patientName"></td>
                <td id="doctorName"></td>
                <td><input type="checkbox" id="appointment" disabled></td>
                <td id="caregiverName"></td>
                <td><input type="checkbox" id="morningMedicine" disabled></td>
                <td><input type="checkbox" id="afternoonMedicine" disabled></td>
                <td><input type="checkbox" id="nightMedicine" disabled></td>
                <td><input type="checkbox" id="breakfast" disabled></td>
                <td><input type="checkbox" id="lunch" disabled></td>
                <td><input type="checkbox" id="dinner" disabled></td>
            </tr>
        </tbody>
    </table>

    <script>
        function resetForm() {
            // Reset the form fields
            document.getElementById('logForm').reset();
            // Clear the error message
            document.getElementById('errorMessage').innerText = '';
            // Hide the table
            document.getElementById('logTable').style.display = 'none';
        }

        document.getElementById('logForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const date = document.getElementById('date').value;
            const familyCode = document.getElementById('familyCode').value;
            const patientId = document.getElementById('patientId').value;

            fetch(`/family-member/logs?date=${date}&familyCode=${familyCode}&patientId=${patientId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => response.json())
                .then(data => {
                    const errorMessage = document.getElementById('errorMessage');
                    const logTable = document.getElementById('logTable');

                    if (data.error) {
                        // Show error message from the backend
                        errorMessage.innerText = data.error;
                        logTable.style.display = 'none';
                    } else if (data.message) {
                        // Show message if no log exists
                        errorMessage.innerText = data.message;
                        logTable.style.display = 'none';
                    } else if (data.log) {
                        // Display the log data in the table
                        errorMessage.innerText = '';
                        logTable.style.display = 'table';
                        document.getElementById('patientName').innerText = data.log.patient_name; // This should work if data.log.patient_name is properly passed
                        document.getElementById('doctorName').innerText = data.log.doctor_name;
                        document.getElementById('caregiverName').innerText = data.log.caregiver_name;
                        document.getElementById('morningMedicine').checked = data.log.morning_med_status;
                        document.getElementById('afternoonMedicine').checked = data.log.afternoon_med_status;
                        document.getElementById('nightMedicine').checked = data.log.night_med_status;
                        document.getElementById('breakfast').checked = data.log.breakfast_status;
                        document.getElementById('lunch').checked = data.log.lunch_status;
                        document.getElementById('dinner').checked = data.log.dinner_status;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('errorMessage').innerText = 'Invalid patient ID or family code.';
                });
        });
    </script>
</div>
    @include('footer')
</body>
</html>
