<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Roster</title>
    @vite(['resources/js/app.js'])
</head>
<body class="newRoster">
    @include('navbar')

    <h1>New Roster</h1>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('newRoster.store') }}" method="POST" class="form">
        @csrf

        <div class="form--box">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" min="{{ date('Y-m-d') }}" required>
        </div>

        <div class="form--box">
            <label for="supervisor">Supervisor:</label>
            <select name="supervisor" id="supervisor" required>
                <option value="">Select Supervisor</option>
                @foreach ($supervisors as $supervisor)
                    <option value="{{ $supervisor->id }}">
                        {{ $supervisor->first_name }} {{ $supervisor->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form--box">
            <label for="doctor">Doctor:</label>
            <select name="doctor" id="doctor" required>
                <option value="">Select Doctor</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">
                        {{ $doctor->first_name }} {{ $doctor->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        @for ($i = 1; $i <= 4; $i++)
            <div class="form--box">
                <label for="caregiver{{ $i }}">Caregiver {{ $i }}:</label>
                <select name="caregiver{{ $i }}" id="caregiver{{ $i }}">
                    <option value="">Select Caregiver</option>
                    @foreach ($caregivers as $caregiver)
                        <option value="{{ $caregiver->id }}">
                            {{ $caregiver->first_name }} {{ $caregiver->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endfor

        <button type="submit" class="submit">Create Roster</button>
        <button type="reset" onclick="resetForm()" class="cancel">Cancel</button>

    </form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        const dateInput = document.getElementById('date');
        dateInput.setAttribute('min', today); // Set the min attribute to today's date
    });

    function resetForm() {
        // Reset all form fields
        $('form')[0].reset();

        // Clear any error messages or additional field modifications
        $('.success').text('').hide();
    }
</script>

    @include('footer')
</body>
</html>