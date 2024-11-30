<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>New Roster</h1>
    <!-- <pre>
        {{ print_r($supervisors) }}
        {{ print_r(value: $doctors) }}
        {{ print_r($caregivers) }}
    </pre> -->


    <form action="{{ route('roster.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
    </div>

    <div class="form-group">
        <label for="supervisor_id">Supervisor</label>
        <select name="supervisor_id" id="supervisor_id" class="form-control">
            <option value="">Select Supervisor</option>
            @foreach($supervisors as $supervisor)
                <option value="{{ $supervisor->id }}" {{ old('supervisor') == $supervisor->id ? 'selected' : '' }}>
                    {{ $supervisor->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
    <label for="doctor_id">Doctor</label>
    <select name="doctor_id" id="doctor_id" class="form-control">
        <option value="">Select Doctor</option>
        @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}" {{ old('doctor') == $doctor->id ? 'selected' : '' }}>
                {{ $doctor->full_name }}
            </option>
        @endforeach
    </select>
</div>

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

</body>
</html>