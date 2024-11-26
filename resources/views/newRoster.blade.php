<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>New Roster</h1>

    @include('navbar')

    <form action="{{ route('newRoster.store') }}" method="POST">
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

</body>
</html>
