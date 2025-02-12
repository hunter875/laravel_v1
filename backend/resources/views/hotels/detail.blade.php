@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4>Hotel details</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>City</th>
                        <td>{{ $hotel->city }}</td>
                    </tr>
                    <tr>
                        <th>Master Code (Vacation)</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Hotel Code (Vacation)</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Hotel Code (Ciao/Challenge)</th>
                        <td>{{ $hotel->hotel_code_ciao }}</td>
                    </tr>
                    <tr>
                        <th>Hotel Code (Skyhub)</th>
                        <td>{{ $hotel->hotel_code_skyhub }}</td>
                    </tr>
                    <tr>
                        <th>Hotel Name (EN)</th>
                        <td>{{ $hotel->hotel_name_en }}</td>
                        <th>Hotel Name (JP)</th>
                        <td>{{ $hotel->hotel_name_jp }}</td>
                    </tr>
                    <tr>
                        <th>Package Tour Hotel Class</th>
                        <td></td>
                        <th>Hotel Class Reserve Flag</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Telephone</th>
                        <td></td>
                        <th>Fax</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Address 1</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Address 2</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Tax Code</th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ route('hotels.index') }}" class="btn btn-secondary">BACK</a>
        </div>
    </div>
</div>
@endsection
