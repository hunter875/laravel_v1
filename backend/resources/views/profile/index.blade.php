@extends('adminlte::page')

@section('title', 'Profile Management')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.css">
@stop

@section('content')
<div class="container">
    <h2>Edit Profile</h2>

    <!-- Hiển thị avatar -->
    <div class="form-group text-center">
        <img id="avatarPreview" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/avatars/default-avatar.png') }}" alt="Avatar" class="img-thumbnail rounded" style="width: 300px; height: 200px; object-fit: cover;">
    </div>

    <!-- Form cập nhật thông tin người dùng -->
    <form id="profileForm" enctype="multipart/form-data" method="POST" action="{{ route('profile.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep the current password">
        </div> @error('password') <small class="text-danger">{{ $message }}</small> @enderror

        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <button type="button" class="btn btn-danger" id="deleteAccount">Delete Account</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Hiển thị preview avatar khi chọn ảnh mới
    $('#avatar').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatarPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Gửi form bằng AJAX
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('profile.update', $user->id) }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert('Profile updated successfully!');
                    $('#name').val(response.data.name);
                    $('#email').val(response.data.email);
                    $('#first_name').val(response.data.first_name);
                    $('#last_name').val(response.data.last_name);
                    if (response.data.avatar_url) {
                        $('#avatarPreview').attr('src', response.data.avatar_url);
                    }
                } else {
                    alert('Update failed: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('There was an error while updating the profile.');
            }
        });
    });
});
</script>
@endpush
