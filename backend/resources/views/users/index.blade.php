@extends('adminlte::page')

@section('title', 'User Management')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.css">
@stop

@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Search Form -->
            <div class="mb-3">
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="input-group">
                    </div>
                </form>
            </div>

            <!-- Add Button -->
            <a href="{{ route('users.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Add User
            </a>

            <!-- Users Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users List</h3>
                </div>
                <div class="card-body">
                    @if($users->isEmpty())
                        <p class="text-center">No users found.</p>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Role</th>
                                    <th>Last Login</th> <!-- Add Last Login column -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $roles->find($user->role_id)->name ?? 'N/A' }}</td>
                                        <td>{{ $user->last_login ? $user->last_login->format('Y-m-d H:i:s') : 'Never' }}</td> <!-- Display Last Login -->
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})" data-toggle="modal" data-target="#confirmDeleteModal">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $users->appends(request()->query())->links() }} <!-- Sử dụng phương thức appends() để phân trang -->
            </div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="delete-form" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(userId) {
            var form = document.getElementById('delete-form');
            form.action = '/users/' + userId;
        }
    </script>
@stop
