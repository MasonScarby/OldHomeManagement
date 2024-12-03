<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js'])
</head>
<body>
@include('navbar')

    <form action="{{ route('appointment.store') }}" method="post">
        @csrf
        <table>
            <tr>
                <td><label for="date">Date</label></td>
                <td><input type="date" id="date" name="date" value="{{ old('date') }}" required></td>
            </tr>

            <tr>
                <td><label for="patient_id">Patient ID</label></td>
                <td>
                    <input type="text" id="patient_id" name="patient_id" value="{{ old('patient_id') }}" required>
                    <button type="button" id="searchButton">Search</button>
                    <div id="patient_id_error" class="error"></div>
                </td>
            </tr>

            <tr>
                <td><label for="patient_name">Patient Name</label></td>
                <td><input type="text" id="patient_name" name="patient_name" readonly></td>
            </tr>

            <tr>
                <td><label for="doctor_id">Doctor</label></td>
                <td>
                    <select name="doctor_id" id="doctor_id" class="form-control" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>

        <div >
            <button type="submit">Ok</button>
            <button type="reset">Cancel</button>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                let patientId = $('#patient_id').val();

                // Clear any previous error messages
                $('#patient_id_error').text('').hide(); 

                if (patientId) {
                    $.ajax({
                        url: "{{ url('/search-patient') }}",
                        method: "GET",
                        data: { patient_id: patientId },
                        success: function(response) {
                            if (response.status === 'success') {
                                // Combine first and last name
                                let patientFullName = response.first_name + ' ' + response.last_name;
                                $('#patient_name').val(patientFullName);
                            } else {
                                $('#patient_id_error').text(response.message).show();
                                $('#patient_name').val(''); // Clear the patient name field
                            }
                        },
                        error: function() {
                            $('#patient_id_error').text('Error occurred while searching.').show();
                        }
                    });
                } else {
                    $('#patient_id_error').text('Please enter a patient ID.').show();
                }
            });
        });
    </script>
</body>
</html>
