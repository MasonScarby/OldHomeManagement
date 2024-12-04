<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    @vite(['resources/js/app.js'])
</head>
<body class="roles">
    @include('navbar')

    <div class="page-container">
        <div class="container">
            <h1>Manage Roles</h1>

            <table class="table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Access Level</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->role_name }}</td>
                            <td>{{ $role->access_level }}</td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>

           <form action="{{route('roles.store')}}" method="POST" class="form">
                @csrf

                <div class="form--box">
                    <label for ="role_name">Role Name:</label>
                    <input type="text" id="role_name" name="role_name" maxlength="20" class="roleNameInput" required>
                </div>
        
                <div class="form--box">
                    <label for="access_level">Access Level:</label>
                    <input type="number" id="access_level" name="access_level" class="accessLevelInput" min="1" max="99999" required>
                </div class="action-buttons">

                <button type="submit" class="createBtn">Create</button>
           </form>
        </div>
    </div>
    
    @include('footer')
</body>
</html> 