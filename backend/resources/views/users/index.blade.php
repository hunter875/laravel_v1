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
                <form id="searchForm">
                    <div class="input-group">
                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search users" value="{{ request('search') }}">
                        <button type="button" id="searchButton" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>

            <!-- Add Button -->
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addUserModal">
                <i class="fas fa-plus"></i> Add User
            </button>

            <!-- Users Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Role</th>
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
                                    <td>{{ $user->role ? $user->role->name : 'N/A' }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-first-name="{{ $user->first_name }}" data-last-name="{{ $user->last_name }}" data-role-id="{{ $user->role_id }}">
                                            <i class="fas fa-pen"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm delete-user" data-id="{{ $user->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links() }} <!-- Tự động hiển thị phân trang -->
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.store') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <small class="text-danger" id="error-name"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                            <small class="text-danger" id="error-email"></small>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" required>
                            <small class="text-danger" id="error-first_name"></small>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" required>
                            <small class="text-danger" id="error-last_name"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            <small class="text-danger" id="error-password"></small>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <select class="form-control" name="role_id" id="role_id">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.update', 'user_id') }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                            <small class="text-danger" id="error-edit-name"></small>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                            <small class="text-danger" id="error-edit-email"></small>
                        </div>
                        <div class="form-group">
                            <label for="edit_first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                            <small class="text-danger" id="error-edit-first_name"></small>
                        </div>
                        <div class="form-group">
                            <label for="edit_last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name" required>
                            <small class="text-danger" id="error-edit-last_name"></small>
                        </div>
                        <div class="form-group">
                            <label for="edit_password">Password</label>
                            <input type="password" class="form-control" name="password" id="edit_password">
                            <small class="text-danger" id="error-edit-password"></small>
                        </div>
                        <div class="form-group">
                            <label for="edit_password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="edit_password_confirmation">
                        </div>
                        <div class="form-group">
                            <label for="edit_role_id">Role</label>
                            <select class="form-control" name="role_id" id="edit_role_id">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    // AJAX SEARCH
    $(document).ready(function () {
        $('#searchButton').on('click', function () {
            var query = $('#searchInput').val();

            $.ajax({
                url: "{{ route('users.searchByName') }}",
                type: "GET",
                data: { search: query },
                success: function (response) {
                    if (response.success && response.users.data.length > 0) {
                        var usersHtml = '';
                        response.users.data.forEach(function (user) {
                            usersHtml += `
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.first_name}</td>
                                    <td>${user.last_name}</td>
                                    <td>${user.role ? user.role.name : 'N/A'}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}" data-first-name="${user.first_name}" data-last-name="${user.last_name}" data-role-id="${user.role_id}">
                                            <i class="fas fa-pen"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-user" data-id="${user.id}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });

                        $('table tbody').html(usersHtml);
                    } else {
                        $('table tbody').html('<tr><td colspan="7" class="text-center">No users found.</td></tr>');
                    }
                },
                error: function (xhr) {
                    alert('Something went wrong!');
                }
            });
        });

        // AJAX ADD
        $('#addUserForm').off('submit').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success) {
                        alert(response.message);

                        $('#addUserModal').modal('hide');

                        let newUserRow = `
                            <tr>
                                <td>${response.user.id}</td>
                                <td>${response.user.name}</td>
                                <td>${response.user.email}</td>
                                <td>${response.user.first_name}</td>
                                <td>${response.user.last_name}</td>
                                <td>${response.user.role ? response.user.role.name : 'N/A'}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="${response.user.id}" data-name="${response.user.name}" data-email="${response.user.email}" data-first-name="${response.user.first_name}" data-last-name="${response.user.last_name}" data-role-id="${response.user.role_id}">
                                        <i class="fas fa-pen"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-user" data-id="${response.user.id}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                        $('table tbody').append(newUserRow);
                    } else {
                        // Hiển thị thông báo lỗi
                        if (response.errors) {
                            if (response.errors.email) {
                                $('#error-email').text(response.errors.email[0]);
                            }
                            if (response.errors.password) {
                                $('#error-password').text(response.errors.password[0]);
                            }
                        } else {
                            alert('Error occurred while adding user.');
                        }
                    }
                },
                error: function (xhr) {
                    alert('Something went wrong!');
                }
            });
        });

        // Populating Edit User Modal
        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userId = button.data('id'); // Extract the user ID
            var name = button.data('name'); // Extract user data
            var email = button.data('email');
            var firstName = button.data('first-name');
            var lastName = button.data('last-name');
            var roleId = button.data('role-id');

            var modal = $(this);
            modal.find('#edit_name').val(name);
            modal.find('#edit_email').val(email);
            modal.find('#edit_first_name').val(firstName);
            modal.find('#edit_last_name').val(lastName);
            modal.find('#edit_role_id').val(roleId);

            // Update the form action to use the correct user ID
            var actionUrl = "{{ route('users.update', ':id') }}".replace(':id', userId);
            modal.find('form').attr('action', actionUrl);
        });

        // AJAX UPDATE USER
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var form = $(this);
            var actionUrl = form.attr('action');
            var formData = form.serialize(); // Get form data

            $.ajax({
                url: actionUrl,
                method: "PUT", // PUT to update the data
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);

                        // Close the modal
                        $('#editUserModal').modal('hide');

                        // Update the row in the table
                        var updatedUserRow = `
                            <tr data-id="${response.user.id}">
                                <td>${response.user.id}</td>
                                <td>${response.user.name}</td>
                                <td>${response.user.email}</td>
                                <td>${response.user.first_name}</td>
                                <td>${response.user.last_name}</td>
                                <td>${response.user.role ? response.user.role.name : 'N/A'}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="${response.user.id}" data-name="${response.user.name}" data-email="${response.user.email}" data-first-name="${response.user.first_name}" data-last-name="${response.user.last_name}" data-role-id="${response.user.role_id}">
                                        <i class="fas fa-pen"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-user" data-id="${response.user.id}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        `;

                        // Find and replace the old row with the new one using data-id
                        $('table tbody tr').each(function() {
                            if ($(this).data('id') == response.user.id) {
                                $(this).replaceWith(updatedUserRow);
                            }
                        });
                    } else {
                        // Hiển thị thông báo lỗi
                        if (response.errors) {
                            if (response.errors.email) {
                                $('#error-edit-email').text(response.errors.email[0]);
                            }
                            if (response.errors.password) {
                                $('#error-edit-password').text(response.errors.password[0]);
                            }
                        } else {
                            alert('Cập nhật người dùng thất bại: ' + response.message);
                        }
                    }
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@stop