<nav>
    <ul> 
        <!-- Admin navbar -->
        @if(Auth::user()->role->access_level === 1)
            <li><a href="{{ route('approval') }}">Approval</a></li>
            <li><a href="{{ route('roles.index') }}">Manage Roles</a></li>
            <li><a href="{{ route('patientList') }}">Patient List</a></li>
            <li><a href="{{ route('patient.assignment') }}">Patient Assignment</a></li>
        @endif

        <!-- Supervisor navbar -->
        @if(Auth::user()->role->access_level === 2)
            <li><a href="{{ route('approval') }}">Approval</a></li>
            <li><a href="{{ route('patientList') }}">Patient List</a></li> 
            <li><a href="{{ route('patient.assignment') }}">Patient Assignment</a></li>
        @endif

        <!-- Doctor Navbar -->
        @if(Auth::user()->role->access_level === 3)
            <li><a href="{{ route('doctorHome') }}">Doctor Home</a></li>
            <li><a href="{{ route('patientList') }}">Patient List</a></li> 
        @endif

        {{-- Caregiver Navbar --}}
        @if(Auth::user()->role->access_level === 4)
            <li><a href="{{ route('caregiverHome') }}">Caregiver Home</a></li>
            <li><a href="{{ route('patientList') }}">Patient List</a></li> 
        @endif

        {{-- Patient Navbar --}}
        @if(Auth::user()->role->access_level === 5)
            <li><a href="{{ route('patientHome') }}">Patient Home</a></li>
        @endif
        {{-- Family Member Navbar --}}
        @if(Auth::user()->role->access_level === 6)
            <li><a href="{{ route('family_memberHome') }}">Family Member Home</a></li>
        @endif
    </ul>

    <!-- Common links for all users -->
    <li>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>    
    </li>
</nav>
