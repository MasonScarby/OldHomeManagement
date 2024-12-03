<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shire Homes</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    @include('navbar')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h1>{{ __('You are logged in as patient!') }}</h1>

    <div>
        <label for="patient-id">Patient ID</label>
        <input type="text" id="patient-id" name="patient-id" value="{{ $patient->id }}" readonly>
    </div>

    <div class="form-group">
        <label for="patient-name">Patient Name</label>
        <input type="text" id="patient-name" name="patient-name" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" readonly>
    </div>

    <div>
        <label for="date">Date</label>
        <input type="date" id="date" name="date" value="{{ $date }}">
        <button id="search-date-btn">Search</button>
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
        <tbody id="log-table-body">
            @if ($log)
                <tr>
                    <td>
                        @if ($doctor)
                            <input type="text" name="doctor-name" value="{{ $doctor->first_name }} {{ $doctor->last_name }}" readonly>
                        @else
                            <input type="text" name="doctor-name" value="No doctor assigned" readonly>
                        @endif
                    </td>
                    <td><input type="checkbox" name="doctor-appointment" {{ $log->doctor_appointment ? 'checked' : '' }} disabled></td>
                    <td>
                        @if ($caregiver)
                            <input type="text" name="caregiver-name" value="{{ $caregiver->first_name }} {{ $caregiver->last_name }}" readonly>
                        @else
                            <input type="text" name="caregiver-name" value="No caregiver assigned" readonly>
                        @endif
                    </td>
                    <td><input type="checkbox" name="morning-medicine" {{ $log->morning_med_status ? 'checked' : '' }} disabled></td>
                    <td><input type="checkbox" name="afternoon-medicine" {{ $log->afternoon_med_status ? 'checked' : '' }} disabled></td>
                    <td><input type="checkbox" name="night-medicine" {{ $log->night_med_status ? 'checked' : '' }} disabled></td>
                    <td><input type="checkbox" name="breakfast" {{ $log->breakfast_status ? 'checked' : '' }} disabled></td>
                    <td><input type="checkbox" name="lunch" {{ $log->lunch_status ? 'checked' : '' }} disabled></td>
                    <td><input type="checkbox" name="dinner" {{ $log->dinner_status ? 'checked' : '' }} disabled></td>
                </tr>
            @else
                <tr>
                    <td colspan="9">No log found for this date.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <script>
        document.getElementById('search-date-btn').addEventListener('click', function() {
            const date = document.getElementById('date').value;
            const patientId = document.getElementById('patient-id').value;
    
            fetch(`/patient/logs/${patientId}/${date}`)
                .then(response => response.json())
                .then(data => {
                    const logTableBody = document.getElementById('log-table-body');
    
                    // Clear current table content
                    logTableBody.innerHTML = '';
    
                    if (data.log) {
                        // Populate the table with the log data
                        const log = data.log;
                        logTableBody.innerHTML = `
                            <tr>
                                <td><input type="text" value="${log.doctor_name}" readonly></td>
                                <td><input type="checkbox" ${log.doctor_appointment ? 'checked' : ''} disabled></td>
                                <td><input type="text" value="${log.caregiver_name}" readonly></td>
                                <td><input type="checkbox" ${log.morning_med_status ? 'checked' : ''} disabled></td>
                                <td><input type="checkbox" ${log.afternoon_med_status ? 'checked' : ''} disabled></td>
                                <td><input type="checkbox" ${log.night_med_status ? 'checked' : ''} disabled></td>
                                <td><input type="checkbox" ${log.breakfast_status ? 'checked' : ''} disabled></td>
                                <td><input type="checkbox" ${log.lunch_status ? 'checked' : ''} disabled></td>
                                <td><input type="checkbox" ${log.dinner_status ? 'checked' : ''} disabled></td>
                            </tr>
                        `;
                    } else {
                        // Display message if no log exists for that date
                        logTableBody.innerHTML = `
                            <tr>
                                <td colspan="9">No log found for this date.</td>
                            </tr>
                        `;
                    }
                })
                .catch(error => console.error('Error fetching log:', error));
        });
    </script>
</body>
</html>
