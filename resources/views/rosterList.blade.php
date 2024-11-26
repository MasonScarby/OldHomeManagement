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


    {{-- <pre>
        {{ print_r($rosters) }} 

    </pre> --}}

    @if(isset($rosters) && $rosters->isNotEmpty())
        <table>
            <tr>
                <th>Date</th>
                <th>Supervisor</th>
                <th>Doctor</th>
                <th>Caregiver 1</th>
                <th>Caregiver 2</th>
                <th>Caregiver 3</th>
                <th>Caregiver 4</th>
            </tr>
            @foreach($rosters as $roster)

                <tr>
                    <td>{{ $roster->date }}</td>
                    <td>{{ $roster->supervisor?->first_name ?? 'No supervisor' }} {{ $roster->supervisor?->last_name ?? '' }}</td>
                    <td>{{ $roster->doctor?->first_name ?? 'No doctor' }} {{ $roster->doctor?->last_name ?? '' }}</td>
                    <td>{{ $roster->caregiver1?->first_name ?? 'No caregiver' }} {{ $roster->caregiver1?->last_name ?? '' }}</td>
                    <td>{{ $roster->caregiver2?->first_name ?? 'No caregiver' }} {{ $roster->caregiver2?->last_name ?? '' }}</td>
                    <td>{{ $roster->caregiver3?->first_name ?? 'No caregiver' }} {{ $roster->caregiver3?->last_name ?? '' }}</td>
                    <td>{{ $roster->caregiver4?->first_name ?? 'No caregiver' }} {{ $roster->caregiver4?->last_name ?? '' }}</td>
                </tr>
            @endforeach
        </table>
    @elseif(isset($date))
        <p>No rosters found for the selected date.</p>
    @endif

</body>
</html>