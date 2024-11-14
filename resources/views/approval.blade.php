@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Approval Dashboard') }}</div>

                <div class="card-body">
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
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
