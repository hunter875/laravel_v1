<!-- filepath: /d:/Work/SmallProject/small-project/resources/views/hotel/index.blade.php -->
@extends('adminlte::page')

@section('title', 'Hotel Management')

@section('content_header')
    <h1>Hotel Management</h1>
@stop


@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('hotels.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" name="cityId">
                            <option value="">--Select City--</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ request('cityId') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="hotelCode" class="form-control" placeholder="Hotel Code" value="{{ request('hotelCode') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="hotelName" class="form-control" placeholder="Hotel Name" value="{{ request('hotelName') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <a href="{{ route('hotels.create') }}" class="btn btn-success mb-3 float-lg-right">Add New Hotel</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>City</th>
                        <th>Hotel Code</th>
                        <th>Hotel Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($hotels->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No data found</td>
                        </tr>
                    @else
                        @foreach($hotels as $hotel)
                            <tr>
                                <td>{{ optional($hotel->city)->name }}</td>
                                <td><span class="badge badge-info">{{ $hotel->hotel_code }}</span></td>
                                <td>{{ $hotel->hotel_name }}</td>
                                <td>{{ $hotel->email }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-sm btn-primary mx-1">View</a>
                                        <a href="{{ route('hotels.edit', $hotel->id) }}" class="btn btn-sm btn-warning mx-1">Edit</a>
                                        <button class="btn btn-sm btn-danger mx-1" onclick="confirmDelete({{ $hotel->id }})" data-toggle="modal" data-target="#confirmDeleteModal">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $hotels->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>

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
                    Are you sure you want to delete this hotel?
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
        function confirmDelete(hotelId) {
            var form = document.getElementById('delete-form');
            form.action = '/hotels/' + hotelId;
        }
    </script>
@stop