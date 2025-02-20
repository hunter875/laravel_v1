@extends('adminlte::page')

@section('title', 'Hotel Details')

@section('content_header')
    <h1>Hotel Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Hotel Name</th>
                    <td>{{ $hotel->hotel_name }}</td>
                </tr>
                <tr>
                    <th>Hotel Code</th>
                    <td>{{ $hotel->hotel_code }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ optional($hotel->city)->name }}</td> <!-- Sử dụng optional để tránh lỗi -->
                </tr>
                <tr>
                    <th>Telephone</th>
                    <td>{{ $hotel->telephone }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $hotel->email }}</td>
                </tr>
                <tr>
                    <th>FAX</th>
                    <td>{{ $hotel->fax }}</td>
                </tr>
                <tr>
                    <th>Company Name</th>
                    <td>{{ $hotel->company_name }}</td>
                </tr>
                <tr>
                    <th>Tax Code</th>
                    <td>{{ $hotel->tax_code }}</td>
                </tr>
                <tr>
                    <th>Address 1</th>
                    <td>{{ $hotel->address1 }}</td>
                </tr>
                <tr>
                    <th>Address 2</th>
                    <td>{{ $hotel->address2 }}</td>
                </tr>
            </tbody>
        </table>
        <div class="text-center mt-3">
            <a href="{{ route('hotels.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@stop