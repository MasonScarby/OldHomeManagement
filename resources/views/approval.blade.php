<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Approval</title>
    @vite(['resources/js/app.js'])
</head>
<body class="approval">
    @include('navbar')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('approveUsers') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Approve</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unapprovedUsers as $user)
                    <tr>
                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                        <td>{{ $user->role->role_name }}</td>
                        <td>
                            <label>
                                <input type="checkbox" name="approval[{{ $user->id }}][yes]" class="approval-checkbox" data-user-id="{{ $user->id }}"> Yes
                            </label>
                            <label>
                                <input type="checkbox" name="approval[{{ $user->id }}][no]" class="approval-checkbox" data-user-id="{{ $user->id }}"> No
                            </label>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No unapproved users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">OK</button>
    </form>

    <script>
        // JavaScript to ensure only one checkbox (Yes or No) is selected per user
        document.querySelectorAll('.approval-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const userId = this.dataset.userId;
                const otherCheckbox = document.querySelector(`input[data-user-id="${userId}"]:not([name="${this.name}"])`);
                if (this.checked) {
                    otherCheckbox.checked = false;
                }
            });
        });
    </script>

    @include('footer')
</body>
</html>
