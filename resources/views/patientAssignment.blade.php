<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patient Assignment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="patient_assignment">
    @include('navbar')

    <h1>Additional Information of Patient</h1>

    @if ($errors->has('patient_id'))
        <div style="color: red;">
            {{ $errors->first('patient_id') }}
        </div>
    @endif

    @if(session('status'))
        <div style="color: green;">
            {{ session('status') }}
        </div>
    @endif

    <div id="patient_id_error" style="color: red; display: none;"></div>


    <form action="{{ url('/patient-assignment') }}" method="POST">
        @csrf

        <label for="patient_id">Patient ID</label>
        <input type="number" id="patient_id" name="patient_id" min="1" required>

        <button type="button" id="searchButton">Search</button>

        <label for="patient_name">Patient Name</label>
        <input type="text" id="patient_name" name="patient_name" readonly>

        <label for="group">Group</label>
        <input type="text" id="group" name="group" maxlength="1" required>

        <label for="admission_date">Admission Date</label>
        <input type="date" id="admission_date" name="admission_date" required>

        <input type="submit" value="Ok">
    </form>


    <script>
    $(document).ready(function() {
        $('#searchButton').click(function() {
            let patientId = $('#patient_id').val();

            // Clear any previous error messages
            $('#patient_id_error').text('').hide(); // Clear and hide the error div before each search

            if (patientId) {
                $.ajax({
                    url: "{{ url('/search-patient') }}", // Define the URL to call
                    method: "GET",
                    data: { patient_id: patientId },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Combine first and last name
                            let patientFullName = response.first_name + ' ' + response.last_name;
                            $('#patient_name').val(patientFullName);
                        } else {
                            // Show error message below the patient_id field
                            $('#patient_id_error').text(response.message).show();
                            $('#patient_name').val(''); // Clear the patient name field
                        }
                    },
                    error: function() {
                        // Show generic error message if the request fails
                        $('#patient_id_error').text('Error occurred while searching.').show();
                    }
                });
            } else {
                // Show error message if patient_id is not entered
                $('#patient_id_error').text('Please enter a patient id.').show();
            }
        });
    });

    // Set the minimum date for the admission_date input
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date(); // Get today's date
        const formattedDate = today.toISOString().split('T')[0]; // Format it as yyyy-mm-dd
        document.getElementById('admission_date').setAttribute('min', formattedDate); // Set the min attribute
    });
</script>

</body>
</html>