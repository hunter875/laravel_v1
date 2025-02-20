@extends('adminlte::page')

@section('title', 'Edit Hotel')

@section('content_header')
    <h1>Edit Hotel</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('hotels.update', $hotel->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('hotels.form', ['hotel' => $hotel, 'cities' => $cities])
                        <button type="submit" class="btn btn-primary">Update Hotel</button>
                    </form>
                  
                </div>
            </div>
        </div>
    </div>
@stop
