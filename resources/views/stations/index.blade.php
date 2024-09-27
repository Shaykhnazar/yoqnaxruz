@extends('layouts.app')

@section('content')
    <section id="features" class="features">
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
                        <h1 class="pb-3" style="font-size:24px;">{{ __('site.my_stations') }}</h1>
                        <a class="btn btn-primary" href="{{ route('stations.create') }}">{{ __('site.add_station') }}</a>
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
                                            <th>{{ __('site.sr') }}</th>
                                            <th>{{ __('site.station_name') }}</th>
                                            <th>{{ __('site.city') }}</th>
                                            <th>{{ __('site.state') }}</th>
                                            <th>{{ __('site.phone') }}</th>
                                            <th>{{ __('site.status') }}</th>
                                            <th>{{ __('site.action') }}</th>
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
                                                <td>{{ $station->status == 1 ? __('site.active') : __('site.inactive') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#stationModal{{ $station->id }}">
                                                        {{ __('site.view') }}
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal for viewing station details -->
                                            <div class="modal fade" id="stationModal{{ $station->id }}" tabindex="-1" role="dialog" aria-labelledby="stationModalLabel{{ $station->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="stationModalLabel{{ $station->id }}">{{ __('site.station_details') }}: {{ $station->station_name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>{{ __('site.station_name') }}: </strong>{{ $station->station_name }}</p>
                                                                    <p><strong>{{ __('site.station_manager_id') }}: </strong>{{ $station->station_manager_id ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.phone') }} 1: </strong>{{ $station->station_phone1 ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.phone') }} 2: </strong>{{ $station->station_phone2 ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.address') }}: </strong>{{ $station->street_address }}</p>
                                                                    <p><strong>{{ __('site.city') }}: </strong>{{ $station->city }}</p>
                                                                    <p><strong>{{ __('site.state') }}: </strong>{{ $station->state }}</p>
                                                                    <p><strong>{{ __('site.zip_code') }}: </strong>{{ $station->zip_code }}</p>
                                                                    <p><strong>{{ __('site.country') }}: </strong>{{ $station->country }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>{{ __('site.opening_hours') }}: </strong>{{ $station->opening_hours ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.closing_time') }}: </strong>{{ $station->closing_time ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.geolocation') }}: </strong>{{ $station->geolocation ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.date_created') }}: </strong>{{ $station->date_created ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.date_verified') }}: </strong>{{ $station->date_verified ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.date_approved') }}: </strong>{{ $station->date_approved ?? 'N/A' }}</p>
                                                                    <p><strong>{{ __('site.verifier') }}: </strong>{{ $station->verifier }}</p>
                                                                    <p><strong>{{ __('site.approver') }}: </strong>{{ $station->approver }}</p>
                                                                    <p><strong>{{ __('site.comments') }}: </strong>{{ $station->comment ?? __('site.no_comments') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.close') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Modal -->
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-center">{{ __('site.no_stations') }}</p>
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
