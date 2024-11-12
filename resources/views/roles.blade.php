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
        <h1>Role</h1>
        <table class="table">
            <tr>
                <th>Role</th>
                <th>Access Level</th>
            </tr>
        </table>
        <form class="input-group">
             <label for="newRole">New Role</label> 
             <input type="text" id="newRole" placeholder="Enter role">
        </form>
        <form class="input-group"> 
            <label for="accessLevel">Access Level</label> 
            <input type="text" id="accessLevel" placeholder="Enter access level"> 
        </form>
        <div class="action-buttons">
            <button>Ok</button>
            <button class="cancel">Cancel</button>
        </div>
    </div>
</body>
</html>