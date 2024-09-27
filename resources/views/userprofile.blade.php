@extends('layouts.app')

@section('title', __('site.user_profile'))

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
                    <div class="section-content" style="margin-left: auto; margin-right: auto; min-height:600px;">
                        <!-- page content -->
                        <div class="right_col" role="main">
                            <div class="clearfix"></div>
                            <div class="sidehead">
                                <h1 class="pb-3" style="font-size:24px;">{{ __('site.welcome') }}, {{ $authUser->role->name ?? __('site.user') }}</h1>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 ">
                                    <!-- Update Profile Form -->
                                    <form method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left" id="updateProfileForm">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" name="uid" value="{{ $authUser->id }}">
                                        </div>

                                        <!-- First Name -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first_name">{{ __('site.first_name') }} <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="first_name" value="{{ $authUser->first_name }}" required="required" class="form-control" placeholder="Enter First Name">
                                                <small id="first_nameError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="surname">{{ __('site.last_name') }} <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="surname" value="{{ $authUser->surname }}" required="required" class="form-control" placeholder="Enter Last Name">
                                                <small id="surnameError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Email Address -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">{{ __('site.email') }} <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="email" name="email" value="{{ $authUser->email }}" required="required" class="form-control" placeholder="Enter Email Address">
                                                <small id="emailError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="date_of_birth">{{ __('site.dob') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="date" name="date_of_birth" value="{{ $authUser->date_of_birth }}" class="form-control">
                                                <small id="dobError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Phone 1 -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone1">{{ __('site.phone1') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="phone1" value="{{ $authUser->phone1 }}" class="form-control">
                                                <small id="phone1Error" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Phone 2 -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone2">{{ __('site.phone2') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="phone2" value="{{ $authUser->phone2 }}" class="form-control">
                                                <small id="phone2Error" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Street Address -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="street_address">{{ __('site.street_address') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="street_address" value="{{ $authUser->street_address }}" class="form-control">
                                                <small id="street_addressError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- City -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="city">{{ __('site.city') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="city" value="{{ $authUser->city }}" class="form-control">
                                                <small id="cityError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- State -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="state">{{ __('site.state') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="state" value="{{ $authUser->state }}" class="form-control">
                                                <small id="stateError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Country -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="country">{{ __('site.country') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="country" value="{{ $authUser->country }}" class="form-control">
                                                <small id="countryError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Zip Code -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="zip">{{ __('site.zip_code') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="zip" value="{{ $authUser->zip }}" class="form-control">
                                                <small id="zipError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Profile Photo -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="photo">{{ __('site.profile_photo') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="file" name="photo" class="form-control">
                                                @if (!empty($authUser->photo))
                                                    <img src="{{ asset($authUser->photo) }}" alt="{{ __('site.profile_photo') }}" style="max-width: 100px; margin-top: 10px;">
                                                @endif
                                                <small id="photoError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Vehicle Model -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="model">{{ __('site.vehicle_model') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="model" value="{{ $authUser->model }}" class="form-control">
                                                <small id="modelError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Registration Number -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="rego">{{ __('site.rego') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="rego" value="{{ $authUser->rego }}" class="form-control">
                                                <small id="regoError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Make -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="make">{{ __('site.make') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="make" value="{{ $authUser->make }}" class="form-control">
                                                <small id="makeError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Year -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="year">{{ __('site.year') }}</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="year" value="{{ $authUser->year }}" class="form-control">
                                                <small id="yearError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="ln_solid"></div>
                                        <div class="item form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <button class="btn btn-primary" type="submit" name="updateUserProfile">
                                                    {{ __('site.update') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-12 col-sm-12 ">
                                    <!-- Reset Password Form -->
                                    <form method="POST" class="form-horizontal form-label-left" id="resetPasswordForm">
                                        @csrf
                                        <!-- Old Password -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="opass">{{ __('site.old_password') }} <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="password" name="opass" required="required" class="form-control" placeholder="{{ __('site.old_password') }}">
                                                <small id="opassError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- New Password -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="npass">{{ __('site.new_password') }} <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="password" name="npass" required="required" class="form-control" placeholder="{{ __('site.new_password') }}">
                                                <small id="npassError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Confirm New Password -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="cpass">{{ __('site.confirm_new_password') }} <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="password" name="cpass" required="required" class="form-control" placeholder="{{ __('site.confirm_new_password') }}">
                                                <small id="cpassError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="ln_solid"></div>
                                        <div class="item form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <button class="btn btn-primary" type="submit" name="userPassReset">
                                                    {{ __('site.reset_password') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- End of row -->
                        </div> <!-- End of right_col -->
                    </div> <!-- End of section-content -->
                </div> <!-- End of rightUSER -->
            </div> <!-- End of row -->
        </div> <!-- End of container -->
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Update Profile Form Submission
            $('#updateProfileForm').on('submit', function(event) {
                event.preventDefault();
                let formData = new FormData(this);

                // Clear previous errors
                $('#first_nameError').text('');
                $('#surnameError').text('');
                $('#emailError').text('');
                $('#photoError').text('');

                $.ajax({
                    url: '{{ route('user.updateProfile') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response.message);
                        // Optionally, reload the page or update the user info on the page
                    },
                    error: function(jqXHR) {
                        if (jqXHR.status === 422) {
                            let errors = jqXHR.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + 'Error').text(value[0]);
                            });
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });

            // Reset Password Form Submission
            $('#resetPasswordForm').on('submit', function(event) {
                event.preventDefault();
                let formData = $(this).serialize();

                // Clear previous errors
                $('#opassError').text('');
                $('#npassError').text('');
                $('#cpassError').text('');

                $.ajax({
                    url: '{{ route('user.resetPassword') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(response.message);
                        $('#resetPasswordForm')[0].reset();
                    },
                    error: function(jqXHR) {
                        if (jqXHR.status === 422) {
                            let errors = jqXHR.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + 'Error').text(value[0]);
                            });
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
@endpush
