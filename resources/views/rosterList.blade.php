<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Roster List</title>
    @vite(['resources/js/app.js'])
</head>
<body class="rosterList">
    @include('navbar')
    <div class="page-container">
        <h1>Roster List</h1>
        <form action="{{ route('rosters.list') }}" method="GET" class="form">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="{{ $date ?? '' }}" required>
            <input type="submit" value="Search" class="submit">
        </form>
    
        @if(isset($date))
            <!-- Display table only if rosters are available -->
            @if(isset($rosters) && $rosters->isNotEmpty())
                <table class="table">
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
            @else
                <p class="ptag">No roster found for the selected date.</p>
            @endif
        @endif
    </div>

    @include('footer')
</body>
</html>