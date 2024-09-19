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
                            <!-- Country -->
                            <div class="form-group">
                                <label for="country">Country<span class="required">*</span></label>
                                <input type="text" class="form-control" id="country" name="country" value="Nigeria" readonly>
                            </div>
                            <!-- Phone -->
                            <div class="form-group">
                                <label for="station_phone">Station Phone</label>
                                <input type="text" class="form-control" id="station_phone" name="station_phone" value="{{ old('station_phone') }}">
                            </div>
                            <!-- Opening Time -->
                            <div class="form-group">
                                <label for="opening_time">Opening Time</label>
                                <input type="time" class="form-control" id="opening_time" name="opening_time" value="{{ old('opening_time') }}">
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
