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
    <!-- <pre>
        {{ print_r($supervisors) }}
        {{ print_r(value: $doctors) }}
        {{ print_r($caregivers) }}
    </pre> -->

        <form action="{{ route('newRoster.store') }}" method="POST" class="form">
            @csrf

        <div>
            <label for="date">Date</label>
            <input type="date" name="date" id="date" min="{{ date('Y-m-d') }}" required>
        </div>

        <div>
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

        <div>
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

<<<<<<< HEAD
<div class="form-group">
    <label for="caregiver1_id">Caregiver 1</label>
    <select name="caregiver1_id" id="caregiver1_id" class="form-control">
        <option value="">Select Caregiver 1</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}" {{ old('caregiver1') == $caregiver->id ? 'selected' : '' }}>
                {{ $caregiver->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver2_id">Caregiver 2</label>
    <select name="caregiver2_id" id="caregiver2_id" class="form-control">
        <option value="">Select Caregiver 2</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}" {{ old('caregiver2') == $caregiver->id ? 'selected' : '' }}>
                {{ $caregiver->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver3_id">Caregiver 3</label>
    <select name="caregiver3_id" id="caregiver3_id" class="form-control">
        <option value="">Select Caregiver 3</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}" {{ old('caregiver3') == $caregiver->id ? 'selected' : '' }}>
                {{ $caregiver->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver4_id">Caregiver 4</label>
    <select name="caregiver4_id" id="caregiver4_id" class="form-control">
        <option value="">Select Caregiver 4</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}" {{ old('caregiver4') == $caregiver->id ? 'selected' : '' }}>
                {{ $caregiver->full_name }}
            </option>
        @endforeach
    </select>
</div>




    <button type="submit" class="btn btn-primary">Submit</button>
</form>
=======
        @for ($i = 1; $i <= 4; $i++)
            <div>
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

        <button type="submit">Create Roster</button>
    </form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        const dateInput = document.getElementById('date');
        dateInput.setAttribute('min', today); // Set the min attribute to today's date
    });
</script>

    @include('footer')
</body>
</html>