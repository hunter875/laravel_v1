@extends('adminlte::page')

@section('title', 'Edit Hotel')

@section('content_header')
    <h1>Edit Hotel</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Hotel</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('hotel.update', $hotel->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Hotel Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $hotel->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="city_id">City *</label>
                        <select class="form-control" name="city_id">
                            <option value="">--Select City--</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $hotel->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tel">Telephone</label>
                        <input type="text" name="tel" class="form-control" value="{{ old('tel', $hotel->tel) }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $hotel->email) }}">
                    </div>
                    <div class="form-group">
                        <label for="address1">Address 1</label>
                        <textarea name="address1" class="form-control">{{ old('address1', $hotel->address1) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hotel_code">Hotel Code</label>
                        <input type="text" name="hotel_code" class="form-control" value="{{ old('hotel_code', $hotel->hotel_code) }}">
                    </div>
                    <div class="form-group">
                        <label for="fax">FAX</label>
                        <input type="text" name="fax" class="form-control" value="{{ old('fax', $hotel->fax) }}">
                    </div>
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $hotel->company_name) }}">
                    </div>
                    <div class="form-group">
                        <label for="tax_code">Tax Code</label>
                        <input type="text" name="tax_code" class="form-control" value="{{ old('tax_code', $hotel->tax_code) }}">
                    </div>
                    <div class="form-group">
                        <label for="address2">Address 2</label>
                        <textarea name="address2" class="form-control">{{ old('address2', $hotel->address2) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <a href="{{ route('hotel.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@stop