<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Roster List</title>
</head>
<body>
    @include('navbar')

    <h1>Roster List</h1>

    <form action="{{ route('rosters.list') }}" method="GET">
        <label for="date">Date</label>
        <input type="date" name="date" id="date" value="{{ $date ?? '' }}" required>
        <input type="submit" value="Search">
    </form>

    @if(isset($rosters) && !empty($rosters))
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Supervisor</th>
                    <th>Doctor</th>
                    <th>Caregiver 1</th>
                    <th>Caregiver 2</th>
                    <th>Caregiver 3</th>
                    <th>Caregiver 4</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rosters as $roster)
                    <tr>
                        <td>{{ $roster['date'] }}</td>
                        <td>{{ $roster['supervisor'] }}</td>
                        <td>{{ $roster['doctor'] }}</td>
                        <td>{{ $roster['caregiver1'] }}</td>
                        <td>{{ $roster['caregiver2'] }}</td>
                        <td>{{ $roster['caregiver3'] }}</td>
                        <td>{{ $roster['caregiver4'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(isset($date))
        <p>No roster found for the selected date.</p>
    @endif
</body>
</html>