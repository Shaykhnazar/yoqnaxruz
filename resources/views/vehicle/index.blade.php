@extends('layouts.app')

@section('content')
    <section id="features" class="features" style="margin-top: 20px; padding-bottom: 0px !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-xs-12 sidebarUSER">
                    <div class="sideINNER">
                        <ul>
                            @include('partials.usernav')
                        </ul>
                    </div>
                </div>
                <div class="col-md-10 col-xs-12 rightUSER">
                    <div class="mt-5 w-100 d-flex justify-content-between">
                        <h1 class="pb-3" style="font-size:24px;">Vehicle List</h1>
                        <a class="btn btn-primary" href="{{ route('vehicle.create') }}">Add Vehicle</a>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-box table-responsive" style="min-height: 450px;">
                                            @if ($vehicles->count() > 0)
                                                <table id="datatable" class="table table-striped table-bordered tablewhite" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Sl.</th>
                                                        <th>Photo</th>
                                                        <th>User</th>
                                                        <th>DOB</th>
                                                        <th>Address</th>
                                                        <th>Phone</th>
                                                        <th>Make</th>
                                                        <th>Model</th>
                                                        <th>Year</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($vehicles as $index => $vehicle)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                @if($vehicle->photo)
                                                                    <img src="{{ asset('storage/' . $vehicle->photo) }}" width="100px" />
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td>{{ $vehicle->user->first_name ?? 'N/A' }}</td>
                                                            <td>{{ $vehicle->dob }}</td>
                                                            <td>{{ $vehicle->street_address }}</td>
                                                            <td>{{ $vehicle->phone1 }}</td>
                                                            <td>{{ $vehicle->make }}</td>
                                                            <td>{{ $vehicle->model }}</td>
                                                            <td>{{ $vehicle->year }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p class="text-center">No vehicle to Display</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        #myForm label .required {
            color: red;
        }
    </style>

@endsection
