@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ $user->role->name }}</td>
            </tr>
            <tr>
                <th>Last Login</th>
                <td>{{ $user->last_login ? $user->last_login->format('Y-m-d H:i:s') : 'Never' }}</td> <!-- Display Last Login -->
            </tr>
        </tbody>
    </table>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
