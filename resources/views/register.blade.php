<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    
    <form action="{{ url('/register')  }}" method="POST">
        @csrf
        <div>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" required>
        </div>

        <div>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" required>
        </div>

        <div>
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" required>
        </div>

        <div>
            <label for="role_id">Role</label>
            <select name="role_id" id="role_id" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                @endforeach
            </select> 
         </div>

        <button type="submit">Register</button>
    </form> 

    <a href="{{ route('login') }}">Login</a>
</body>
</html>