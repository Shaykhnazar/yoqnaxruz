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
                        <h1 class="pb-3" style="font-size:24px;">My Stations</h1>
                        <a class="btn btn-primary" href="{{ route('stations.create') }}">Add Station</a>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_content">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if($stations->count() > 0)
                                    <table class="table table-responsive table-striped table-bordered tablewhite" style="min-height: 450px;">
                                        <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Station Name</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($stations as $index => $station)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $station->station_name }}</td>
                                                <td>{{ $station->city }}</td>
                                                <td>{{ $station->state }}</td>
                                                <td>{{ $station->station_phone1 ?? $station->station_phone2 }}</td>
                                                <td>{{ $station->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#stationModal{{ $station->id }}">
                                                        View
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal for viewing station details -->
                                            <div class="modal fade" id="stationModal{{ $station->id }}" tabindex="-1" role="dialog" aria-labelledby="stationModalLabel{{ $station->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="stationModalLabel{{ $station->id }}">Station Details: {{ $station->station_name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>Station Name: </strong>{{ $station->station_name }}</p>
                                                                    <p><strong>Station Manager ID: </strong>{{ $station->station_manager_id ?? 'N/A' }}</p>
                                                                    <p><strong>Phone 1: </strong>{{ $station->station_phone1 ?? 'N/A' }}</p>
                                                                    <p><strong>Phone 2: </strong>{{ $station->station_phone2 ?? 'N/A' }}</p>
                                                                    <p><strong>Address: </strong>{{ $station->street_address }}</p>
                                                                    <p><strong>City: </strong>{{ $station->city }}</p>
                                                                    <p><strong>State: </strong>{{ $station->state }}</p>
                                                                    <p><strong>Zip Code: </strong>{{ $station->zip_code }}</p>
                                                                    <p><strong>Country: </strong>{{ $station->country }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Opening Hours: </strong>{{ $station->opening_hours ?? 'N/A' }}</p>
                                                                    <p><strong>Closing Time: </strong>{{ $station->closing_time ?? 'N/A' }}</p>
                                                                    <p><strong>Geolocation: </strong>{{ $station->geolocation ?? 'N/A' }}</p>
                                                                    <p><strong>Date Created: </strong>{{ $station->date_created ?? 'N/A' }}</p>
                                                                    <p><strong>Date Verified: </strong>{{ $station->date_verified ?? 'N/A' }}</p>
                                                                    <p><strong>Date Approved: </strong>{{ $station->date_approved ?? 'N/A' }}</p>
                                                                    <p><strong>Verifier: </strong>{{ $station->verifier }}</p>
                                                                    <p><strong>Approver: </strong>{{ $station->approver }}</p>
                                                                    <p><strong>Comments: </strong>{{ $station->comment ?? 'No comments' }}</p>
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
                                    <p class="text-center">No stations to display.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .modal-body p {
            margin-bottom: 0.5rem;
        }
    </style>
@endsection
