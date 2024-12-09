<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/js/app.js'])
</head>
<body class="register">
    @include('navbar')

    <div class="page-container">
        <div class="registerBox">
            <h1>Register</h1>

            @if($errors->any())
                <div style="color: red;">
                    <ul class="ul">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            
            <form action="{{ url('/register')  }}" method="POST" class="form">
                @csrf
        
                <div class="form--box">
                    <label for="role_id">Role</label>
                    <select name="role_id" id="role_id" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select> 
                 </div>
        
                <div class="form--box">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" maxlength="20" required>
                </div>
        
                <div class="form--box">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" maxlength="20" required>
                </div>
        
                <div class="form--box">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" maxlength="254" required>
                </div>
        
                <div class="form--box">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" maxlength="255" required>
                </div>
        
                <div class="form--box">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" maxlength="15" required>
                </div>
        
                <div class="form--box">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" max="{{ date('Y-m-d') }}" required>
                </div>
        
                <div id="patientFields" style="display: none;">
                    <div class="form--box">
                        <label for="family_code">Family Code</label>
                        <input type="text" name="family_code" id="family_code" maxlength="5">
                    </div>

                    <div class="form--box form--box-ec">
                        <label for="emergency_contact">Emergency Contact Number</label>
                        <input type="text" name="emergency_contact" id="emergency_contact" maxlength="15">
                    </div>

                    <div class="form--box">
                        <label for="contact_relationship">Relation to Emergency Contact</label>
                        <input type="text" name="contact_relationship" id="contact_relationship" maxlength="20">
                    </div>
                </div>
                
                <button type="submit" class="submit">Register</button>
            </form> 
        </div>
    </div>
    
    <script>
        const roleSelect = document.getElementById('role_id');
        const patientFields = document.getElementById('patientFields');
        const familyCodeInput = document.getElementById('family_code');
        const emergencyContactInput = document.getElementById('emergency_contact');
        const contactRelationshipInput = document.getElementById('contact_relationship');

        roleSelect.addEventListener('change', () => {
            if (roleSelect.options[roleSelect.selectedIndex].text === 'Patient' || roleSelect.options[roleSelect.selectedIndex].text === 'patient' ) {
                patientFields.style.display = 'block';
                familyCodeInput.required = true;
                emergencyContactInput.required = true;
                contactRelationshipInput.required = true;
            } else {
                patientFields.style.display = 'none';
                familyCodeInput.required = false;
                emergencyContactInput.required = false;
                contactRelationshipInput.required = false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const images = [
                'url("{{ asset('images/image1.png') }}")',
                'url("{{ asset('images/image2.png') }}")',
                'url("{{ asset('images/image3.png') }}")'
            ];

            let currentImageIndex = 0;

            document.body.style.backgroundImage = images[currentImageIndex];

            setInterval(function() {
                currentImageIndex = (currentImageIndex + 1) % images.length;
                document.body.style.backgroundImage = images[currentImageIndex];
            }, 6000);
        });
    </script>

    @include('footer')
</body>
</html>