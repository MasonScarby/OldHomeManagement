<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js'])
    <style>
        body {
    background-color: whitesmoke;
    font-family: Arial, sans-serif;
    color: #303030;
    margin: 0;
    padding: 20px;
}

h1, h2 {
    color: #303030;
}

form {
    background-color: #E4C297;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    max-width: 600px;
    margin: 20px auto;
}

form table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

form table td {
    padding: 10px;
    vertical-align: middle;
}

form table label {
    font-weight: bold;
    color: #303030;
}

form input[type="text"], 
form input[type="date"], 
form select {
    width: 100%;
    padding: 10px;
    border: 1px solid #303030;
    border-radius: 5px;
    background-color: whitesmoke;
    color: #303030;
    box-sizing: border-box;
}

form input[readonly] {
    background-color: #f0f0f0;
    color: #707070;
}

form button {
    background-color: #303030;
    color: whitesmoke;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    font-weight: bold;
    cursor: pointer;
    margin-right: 10px;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #505050;
}

form button[type="reset"] {
    background-color: #E4C297;
    color: #303030;
}

form button[type="reset"]:hover {
    background-color: #D2A676;
}

.error {
    color: red;
    font-size: 0.9em;
    margin-top: 5px;
    display: none;
}

@media (max-width: 600px) {
    form {
        padding: 15px;
    }

    form table td {
        display: block;
        width: 100%;
        padding: 5px 0;
    }

    form table label {
        margin-bottom: 5px;
    }
}

    </style>
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

    @include('footer')
</body>
</html>
