<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>New Roster</h1>

    <form action="{{ route('roster.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
    </div>

    <div class="form-group">
        <label for="supervisor">Supervisor</label>
        <select name="supervisor" id="supervisor" class="form-control">
            <option value="">Select Supervisor</option>
            @foreach($supervisors as $supervisor)
                <option value="{{ $supervisor->id }}" {{ old('supervisor') == $supervisor->id ? 'selected' : '' }}>
                    {{ $supervisor->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
    <label for="doctor">Doctor</label>
    <select name="doctor" id="doctor" class="form-control">
        <option value="">Select Doctor</option>
        @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}" {{ old('doctor') == $doctor->id ? 'selected' : '' }}>
                {{ $doctor->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver1">Caregiver 1</label>
    <select name="caregiver1" id="caregiver1" class="form-control">
        <option value="">Select Caregiver 1</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}" {{ old('caregiver1') == $caregiver->id ? 'selected' : '' }}>
                {{ $caregiver->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver2">Caregiver 2</label>
    <select name="caregiver2" id="caregiver2" class="form-control">
        <option value="">Select Caregiver 2</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}" {{ old('caregiver2') == $caregiver->id ? 'selected' : '' }}>
                {{ $caregiver->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver3">Caregiver 3</label>
    <select name="caregiver3" id="caregiver3" class="form-control">
        <option value="">Select Caregiver 3</option>
        @foreach($caregivers as $caregiver)
            <option value="{{ $caregiver->id }}" {{ old('caregiver3') == $caregiver->id ? 'selected' : '' }}>
                {{ $caregiver->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="caregiver4">Caregiver 4</label>
    <select name="caregiver4" id="caregiver4" class="form-control">
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

</body>
</html>