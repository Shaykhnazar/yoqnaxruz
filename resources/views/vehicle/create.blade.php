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
                    <div class="section-content" style="margin-left: auto; margin-right: auto;">
                        <h1 class="pb-3" style="font-size:24px;">Add Vehicle</h1>
                        <form method="POST" action="{{ route('vehicle.store') }}" enctype="multipart/form-data" id="myForm">
                            @csrf
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Title<span class="required">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- First Name -->
                            <div class="form-group">
                                <label for="first_name">First Name<span class="required">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}">
                                @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Middle Name -->
                            <div class="form-group">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                                @error('middle_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <label for="last_name">Last Name<span class="required">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}">
                                @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Address, City, State -->
                            <div class="form-group">
                                <label for="street_address">Street Address<span class="required">*</span></label>
                                <input type="text" class="form-control" id="street_address" name="street_address" value="{{ old('street_address') }}">
                                @error('street_address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="city">City<span class="required">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                                @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="state">Select State<span class="required">*</span></label>
                                <select class="form-control" id="state" name="state">
                                    @foreach ($states as $state)
                                        <option value="{{ $state }}">{{ $state }}</option>
                                    @endforeach
                                </select>
                                @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Zip, Country, Phones -->
                            <div class="form-group">
                                <label for="zipcode">Zip Code<span class="required">*</span></label>
                                <input type="text" class="form-control" id="zipcode" name="zipcode" value="{{ old('zipcode') }}">
                                @error('zipcode') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="country">Country<span class="required">*</span></label>
                                <input type="text" class="form-control" id="country" name="country" value="Nigeria" readonly>
                            </div>

                            <!-- Phone Numbers -->
                            <div class="form-group">
                                <label for="phone">Phone<span class="required">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone2">Phone 2</label>
                                <input type="text" class="form-control" id="phone2" name="phone2" value="{{ old('phone2') }}">
                                @error('phone2') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Make, Model, Year -->
                            <div class="form-group">
                                <label for="make">Make</label>
                                <input type="text" class="form-control" id="make" name="make" value="{{ old('make') }}">
                            </div>
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}">
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select class="form-control" id="year" name="year">
                                    <option value="">Select</option>
                                    @for ($year = date("Y"); $year >= 2000; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Photo -->
                            <div class="custom-file mb-2">
                                <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                <label class="custom-file-label" for="attachment">Upload Photo</label>
                                @error('attachment') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Vehicle</button>
                            </div>
                        </form>
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
