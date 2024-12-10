<header class="header">
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>

        <!-- Admin navbar -->
        @if(Auth::check() && Auth::user()->role && Auth::user()->role->access_level === 1)
            <li><a href="{{ route('approval') }}"><p class="p">Approval</p></a></li>
            <li><a href="{{ route('roles.index') }}"><p class="p">Manage Roles</p></a></li>
            <li><a href="{{ route('patientList') }}"><p class="p">Patient List</p></a></li>
            <li><a href="{{ route('patient.assignment') }}"><p class="p">Patient Assignment</p></a></li>
            <li><a href="{{ route('newRoster.create') }}"><p class="p">New Roster</p></a></li>
            <li><a href="{{ route('admin-report.index') }}"><p class="p">Admin Report</p></a></li>
            <li><a href="{{ route('employees.index') }}"><p class="p">Employees</p></a></li>
            <li><a href="{{ route('appointment.appointmentForm') }}"><p class="p">Create Appointment</p></a></li>
            <li><a href="{{ route('payment.payment') }}"><p class="p">Payment</p></a></li>
        @endif

        <!-- Supervisor navbar -->
        @if(Auth::check() && Auth::user()->role && Auth::user()->role->access_level === 2)
            <li><a href="{{ route('approval') }}"><p class="p">Approval</p></a></li>
            <li><a href="{{ route('patientList') }}"><p class="p">Patient List</p></a></li>
            <li><a href="{{ route('patient.assignment') }}"><p class="p">Patient Assignment</p></a></li>
            <li><a href="{{ route('newRoster.create') }}"><p class="p">New Roster</p></a></li>
            <li><a href="{{ route('admin-report.index') }}"><p class="p">Admin Report</p></a></li>
            <li><a href="{{ route('employees.index') }}"><p class="p">Employees</p></a></li>
            <li><a href="{{ route('appointment.appointmentForm') }}"><p class="p">Create Appointment</p></a></li>
        @endif
    
        <!-- Doctor Navbar -->
        @if(Auth::check() && Auth::user()->role && Auth::user()->role->access_level === 3)
            <li><a href="{{ route('doctorList') }}"><p class="p">Doctor Home</p></a></li>
            <li><a href="{{ route('patientList') }}"><p class="p">Patient List</p></a></li> 
        @endif
    
        {{-- Caregiver Navbar --}}
        @if(Auth::check() && Auth::user()->role && Auth::user()->role->access_level === 4)
            <li><a href="{{ route('caregiverHome') }}"><p class="p">Caregiver Home</p></a></li>
            <li><a href="{{ route('patientList') }}"><p class="p">Patient List</p></a></li> 
        @endif
    
        {{-- Patient Navbar --}}
        @if(Auth::check() && Auth::user()->role && Auth::user()->role->access_level === 5)
            <li><a href="{{ route('patientHome') }}"><p class="p">Patient Home</p></a></li>
        @endif
    
        {{-- Family Member Navbar --}}
        @if(Auth::check() && Auth::user()->role && Auth::user()->role->access_level === 6)
            <li><a href="{{ route('family_memberHome') }}"><p class="p">Family Member Home</p></a></li>
        @endif
    
        <!-- Common links for all users -->
        @auth
            <!-- Hide the "Roster List" link on login and register pages -->
            @if (!Request::is('login') && !Request::is('register'))
                <li><a href="{{ route('rosters.list') }}"><p class="p">Roster List</p></a></li>
            @endif

            <!-- Hide the Logout button on login or register page -->
            @if (!Request::is('login') && !Request::is('register'))
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout">Logout</button>
                    </form>    
                </li>
            @endif
        @endauth

         <!-- Links for users on login or register page -->
         @guest
         @if (Request::is('login') || Request::is('/'))
             <li><a href="{{ route('register') }}"><p class="p">Register</p></a></li>
         @elseif (Request::is('register'))
             <li><a href="{{ route('login') }}"><p class="p">Login</p></a></li>
         @endif
     @endguest
    </nav>    
</header>

