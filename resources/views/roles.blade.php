<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Creator</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container">
        <h1>Role History</h1>
        <table class="table">
            <tr>
                <th>Role</th>

                <th>Access Level</th>
            </tr>
            <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->role_name }}</td>
                <td>{{ $role->access_level }}</td> 
            </tr>
        @endforeach
    </tbody>
        </table>
       <form action="{{route('roles.store')}}" method="POST">
        @csrf
        <div class="input-group">
            <label for ="role_name">Role Name:</label>
            <input type="text" id="role_name" name="role_name" required>
        </div>

        <div class="input-group">
            <label for="access_level">Access Level:</label>
            <input type="number" id="access_level" name="access_level" required>
        </div class="action-buttons">
        <button type="submit">Create</button>
        <button type="submit">Cancel</button>
       </form>
    </div>
</body>
</html>