<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @include('navbar')

    <h1>New Roster</h1>

    <form action="{{ route('roster.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
    </div>

    <div class="form-group">
        <label for="supervisor_id">Supervisor</label>
        <select name="supervisor_id" id="supervisor_id" class="form-control" required>
            @foreach($supervisors as $supervisor)
                <option value="{{ $supervisor->id }}">{{ $supervisor->full_name }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label for="doctor_id">Doctor</label>
        <select name="doctor_id" id="doctor_id" class="form-control" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
            @endforeach
        </select>
    </div>
    
    @for($i = 1; $i <= 4; $i++)
        <div class="form-group">
            <label for="caregiver{{ $i }}">Caregiver {{ $i }}</label>
            <select name="caregiver{{ $i }}" id="caregiver{{ $i }}" class="form-control" required>
                @foreach($caregivers as $caregiver)
                    <option value="{{ $caregiver->id }}">{{ $caregiver->full_name }}</option>
                @endforeach
            </select>
        </div>
    @endfor
    </select>
</div>

<div class="form-group">
    <label for="caregiver2">Caregiver 2</label>
    <select name="caregiver2" id="caregiver2" class="form-control">
        <option value="">Select Caregiver 2</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}">{{ $caregiver->full_name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver3">Caregiver 3</label>
    <select name="caregiver3" id="caregiver3" class="form-control">
        <option value="">Select Caregiver 3</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}">{{ $caregiver->full_name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver4">Caregiver 4</label>
    <select name="caregiver4" id="caregiver4" class="form-control">
        <option value="">Select Caregiver 4</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}">{{ $caregiver->full_name }}</option>
        @endforeach
    </select>
</div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        const dateInput = document.getElementById('date');
        dateInput.setAttribute('min', today); // Set the min attribute to today's date
    });
</script>

</body>
</html>