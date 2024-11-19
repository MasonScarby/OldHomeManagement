@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav>
            <ul>
                <li><a href="{{ route('patientList') }}">Patient List</a></li>
            </ul>
        </nav>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Doctor Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as doctor!') }}

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
