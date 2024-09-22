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
                                                        <th>User</th>
                                                        <th>DOB</th>
                                                        <th>Address</th>
                                                        <th>Phone</th>
                                                        <th>Make</th>
                                                        <th>Model</th>
                                                        <th>Year</th>
                                                        <th>Photo</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($vehicles as $index => $vehicle)
                                                        <tr data-toggle="modal" data-target=".vehicle-modal-{{ $vehicle->id }}" style="cursor:pointer">
                                                            <td>{{ $index + 1 }}</td>

                                                            <td>{{ $vehicle->user->first_name ?? 'N/A' }}</td>
                                                            <td>{{ $vehicle->dob }}</td>
                                                            <td>{{ $vehicle->street_address }}</td>
                                                            <td>{{ $vehicle->phone1 }}</td>
                                                            <td>{{ $vehicle->make }}</td>
                                                            <td>{{ $vehicle->model }}</td>
                                                            <td>{{ $vehicle->year }}</td>
                                                            <td>
                                                                @if($vehicle->photo)
                                                                    <img src="{{ asset('storage/' . $vehicle->photo) }}" width="100px" />
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td><span class="badge badge-primary">View</span></td>
                                                        </tr>

                                                        <!-- Modal -->
                                                        <div class="modal fade vehicle-modal-{{ $vehicle->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-xl" style="max-width:650px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Vehicle Details</h4>
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row mb-4">
                                                                            <div class="col-lg-12">
                                                                                @if($vehicle->photo)
                                                                                    <img src="{{ asset('storage/'.$vehicle->photo) }}" width="400px" />
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mb-4">
                                                                            <div class="col-lg-6">
                                                                                <p><strong>User Name: </strong>{{ $vehicle->user->first_name ?? 'N/A' }}</p>
                                                                                <p><strong>Date of Birth: </strong>{{ $vehicle->dob }}</p>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <p><strong>Address: </strong>{{ $vehicle->street_address }}</p>
                                                                                <p><strong>Phone: </strong>{{ $vehicle->phone1 }}</p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mb-4">
                                                                            <div class="col-lg-6">
                                                                                <p><strong>Make: </strong>{{ $vehicle->make }}</p>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <p><strong>Model: </strong>{{ $vehicle->model }}</p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mb-4">
                                                                            <div class="col-lg-6">
                                                                                <p><strong>Year: </strong>{{ $vehicle->year }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End of Modal -->
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
