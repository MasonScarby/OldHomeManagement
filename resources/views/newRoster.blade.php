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

    @include('navbar')

    <form action="{{ route('newRoster.store') }}" method="POST">
        @csrf

<<<<<<< HEAD
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
=======
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
>>>>>>> ad26fa54b6adb5a30f5dd1d6022296267f880ff2

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        const dateInput = document.getElementById('date');
        dateInput.setAttribute('min', today); // Set the min attribute to today's date
    });
</script>

</body>
</html>
