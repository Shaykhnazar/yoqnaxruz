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
                        <a class="btn btn-primary" href="{{ route('station-manager.stations.create') }}">Add Station</a>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_content">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if($stations->count() > 0)
                                    <table class="table table-striped table-bordered tablewhite" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Station Name</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($stations as $index => $station)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $station->station_name }}</td>
                                                <td>{{ $station->city }}</td>
                                                <td>{{ $station->state }}</td>
                                                <td>{{ $station->station_phone }}</td>
                                                <td>{{ $station->status == 1 ? 'Active' : 'Inactive' }}</td>
                                            </tr>
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
@endsection
