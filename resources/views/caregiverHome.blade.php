<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregiver Home</title>
    @vite(['resources/js/app.js'])
</head>
<body class="caregiverHome">
    @include('navbar')

    <h1>Caregiver Dashboard</h1>
    <p>{{ __('Date: ') }} {{ $date }}</p>

    <div class="alert alert-success" role="alert">
        <!-- Success message will appear here -->
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->user->first_name }} {{ $patient->user->last_name }}</td>
                    <td><input type="checkbox" data-field="morning_med_status" {{ $patient->logs->first()?->morning_med_status ? 'checked' : '' }}></td>
                    <td><input type="checkbox" data-field="afternoon_med_status" {{ $patient->logs->first()?->afternoon_med_status ? 'checked' : '' }}></td>
                    <td><input type="checkbox" data-field="night_med_status" {{ $patient->logs->first()?->night_med_status ? 'checked' : '' }}></td>
                    <td><input type="checkbox" data-field="breakfast_status" {{ $patient->logs->first()?->breakfast_status ? 'checked' : '' }}></td>
                    <td><input type="checkbox" data-field="lunch_status" {{ $patient->logs->first()?->lunch_status ? 'checked' : '' }}></td>
                    <td><input type="checkbox" data-field="dinner_status" {{ $patient->logs->first()?->dinner_status ? 'checked' : '' }}></td>
                    <td>
                        <button class="save-log-btn" 
                            data-patient-id="{{ $patient->id }}" 
                            data-caregiver-id="{{ Auth::id() }}">OK</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.querySelectorAll('.save-log-btn').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr');
                const patientId = this.getAttribute('data-patient-id');
                const caregiverId = this.getAttribute('data-caregiver-id');
                const date = '{{ $date }}';

                const data = {
                    patient_id: patientId,
                    caregiver_id: caregiverId,
                    date: date,
                    morning_med_status: row.querySelector('[data-field="morning_med_status"]').checked,
                    afternoon_med_status: row.querySelector('[data-field="afternoon_med_status"]').checked,
                    night_med_status: row.querySelector('[data-field="night_med_status"]').checked,
                    breakfast_status: row.querySelector('[data-field="breakfast_status"]').checked,
                    lunch_status: row.querySelector('[data-field="lunch_status"]').checked,
                    dinner_status: row.querySelector('[data-field="dinner_status"]').checked,
                };

                fetch('{{ route('patientLogs.storeOrUpdate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    const alertDiv = document.querySelector('.alert');
                    alertDiv.textContent = data.message; // Set the success message
                    alertDiv.style.display = 'block'; // Show the alert div
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>