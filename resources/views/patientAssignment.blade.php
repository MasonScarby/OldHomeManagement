<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patient Assignment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="patientAssignment">
    @include('navbar')
    <div class='page-container'>
        <h1>Additional Information of Patient</h1>

        @if ($errors->any())
            <ul style="color: red;" class="ul">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if(session('status'))
            <div style="color: green;" class="success">
                {{ session('status') }}
            </div>
        @endif



        <form action="{{ url('/patient-assignment') }}" method="POST" class='form'>
            @csrf

            <div id="patient_id_error" style="color: red; display: none;"></div>


            <label for="patient_id">Patient ID</label>
            <input type="number" id="patient_id" name="patient_id" placeholder="Enter ID" min="1" required>

            <button type="button" id="searchButton">Search</button>

            <label for="patient_name">Patient Name</label>
            <input type="text" id="patient_name" name="patient_name" placeholder="Name will appear here upon search" readonly required>

            <label for="group">Group</label>
            <select id="group" name="group" required>
                <option value="">Select a Group</option> <!-- Default option -->
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>

            <label for="admission_date">Admission Date</label>
            <input type="date" id="admission_date" name="admission_date" required>

            <button type="submit" id="okButton">Ok</button>
            <button type="reset" onclick="resetForm()">Cancel</button>
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

            function resetForm() {
        // Reset all form fields
        $('form')[0].reset();

        // Clear the patient name field (since it’s readonly, but we can still clear its value)
        $('#patient_name').val('');

        // Clear any error messages
        $('#patient_id_error').text('').hide();
    }
        </script>
    </div> 
    @include('footer')
</body>
</html>