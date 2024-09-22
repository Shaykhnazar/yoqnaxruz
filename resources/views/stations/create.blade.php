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
                        <h1 class="pb-3" style="font-size:24px;">Add Fuel Station</h1>
                        <form method="POST" action="{{ route('stations.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Hidden fields to store latitude and longitude -->
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">

                            <!-- Station Name -->
                            <div class="form-group">
                                <label for="station_name">Station Name<span class="required">*</span></label>
                                <input type="text" class="form-control" id="station_name" name="station_name" value="{{ old('station_name') }}" required>
                                @error('station_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <!-- Address -->
                            <div class="form-group">
                                <label for="street_address">Street Address<span class="required">*</span></label>
                                <input type="text" class="form-control" id="street_address" name="street_address" value="{{ old('street_address') }}" required>
                                @error('street_address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <!-- City -->
                            <div class="form-group">
                                <label for="city">City<span class="required">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                                @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <!-- State -->
                            <div class="form-group">
                                <label for="state">State<span class="required">*</span></label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" required>
                                @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <!-- Zip Code -->
                            <div class="form-group">
                                <label for="zip_code">Zip Code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}">
                                @error('zip_code') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Country -->
                            <div class="form-group">
                                <label for="country">Country<span class="required">*</span></label>
                                <input type="text" class="form-control" id="country" name="country" value="Nigeria" readonly>
                            </div>
                            <!-- Phone 1 -->
                            <div class="form-group">
                                <label for="station_phone1">Station Phone 1</label>
                                <input type="text" class="form-control" id="station_phone1" name="station_phone1" value="{{ old('station_phone1') }}">
                                @error('station_phone1') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Phone 2 -->
                            <div class="form-group">
                                <label for="station_phone2">Station Phone 2</label>
                                <input type="text" class="form-control" id="station_phone2" name="station_phone2" value="{{ old('station_phone2') }}">
                                @error('station_phone2') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <!-- Opening Time -->
                            <div class="form-group">
                                <label for="opening_hours">Opening Time</label>
                                <input type="time" class="form-control" id="opening_hours" name="opening_hours" value="{{ old('opening_hours') }}">
                            </div>
                            <!-- Closing Time -->
                            <div class="form-group">
                                <label for="closing_time">Closing Time</label>
                                <input type="time" class="form-control" id="closing_time" name="closing_time" value="{{ old('closing_time') }}">
                            </div>
                            <!-- Comments -->
                            <div class="form-group">
                                <label for="comment">Comments</label>
                                <textarea class="form-control" name="comment" id="comment" rows="5">{{ old('comment') }}</textarea>
                            </div>
                            <!-- Attachment -->
                            <div class="custom-file mb-2">
                                <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                <label class="custom-file-label" for="attachment">Upload Photo</label>
                                @error('attachment') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mt-3">Add Station</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if the Geolocation API is supported by the browser
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        // Success callback: store latitude and longitude in hidden fields
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                    },
                    function (error) {
                        // Error callback: handle errors if user denies or there are issues
                        console.error("Error getting geolocation: ", error.message);
                    }
                );
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        });
    </script>
@endpush
