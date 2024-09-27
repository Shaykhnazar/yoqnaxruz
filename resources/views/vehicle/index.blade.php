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
                        <h1 class="pb-3" style="font-size:24px;">{{ __('site.vehicle_list') }}</h1>
                        <a class="btn btn-primary" href="{{ route('vehicle.create') }}">{{ __('site.add_vehicle') }}</a>
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
                                                        <th>{{ __('site.sl') }}</th>
                                                        <th>{{ __('site.user') }}</th>
                                                        <th>{{ __('site.dob') }}</th>
                                                        <th>{{ __('site.address') }}</th>
                                                        <th>{{ __('site.phone') }}</th>
                                                        <th>{{ __('site.make') }}</th>
                                                        <th>{{ __('site.model') }}</th>
                                                        <th>{{ __('site.year') }}</th>
                                                        <th>{{ __('site.photo') }}</th>
                                                        <th>{{ __('site.action') }}</th>
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
                                                            <td><span class="badge badge-primary">{{ __('site.view') }}</span></td>
                                                        </tr>

                                                        <!-- Modal -->
                                                        <div class="modal fade vehicle-modal-{{ $vehicle->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-xl" style="max-width:650px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">{{ __('site.vehicle_details') }}</h4>
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
                                                                                <p><strong>{{ __('site.user') }}: </strong>{{ $vehicle->user->first_name ?? 'N/A' }}</p>
                                                                                <p><strong>{{ __('site.dob') }}: </strong>{{ $vehicle->dob }}</p>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <p><strong>{{ __('site.address') }}: </strong>{{ $vehicle->street_address }}</p>
                                                                                <p><strong>{{ __('site.phone') }}: </strong>{{ $vehicle->phone1 }}</p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mb-4">
                                                                            <div class="col-lg-6">
                                                                                <p><strong>{{ __('site.make') }}: </strong>{{ $vehicle->make }}</p>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <p><strong>{{ __('site.model') }}: </strong>{{ $vehicle->model }}</p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mb-4">
                                                                            <div class="col-lg-6">
                                                                                <p><strong>{{ __('site.year') }}: </strong>{{ $vehicle->year }}</p>
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
                                                <p class="text-center">{{ __('site.no_vehicle') }}</p>
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
