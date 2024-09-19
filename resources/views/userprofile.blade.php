{{-- resources/views/userprofile.blade.php --}}
@extends('layouts.app')

@section('title', 'User Profile')

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
                    <div class="section-content" style="margin-left: auto; margin-right: auto; min-height:600px;">
                        <!-- page content -->
                        <div class="right_col" role="main">
                            <div class="clearfix"></div>
                            <div class="sidehead">
                                <h1 class="pb-3" style="font-size:24px;">Welcome, {{ Auth::user()->role->name ?? 'User' }}</h1>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 ">
                                    <!-- Update Profile Form -->
                                    <form method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left" id="updateProfileForm">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" name="uid" value="{{ Auth::user()->id }}">
                                        </div>

                                        <!-- First Name -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first_name">First Name <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="first_name" value="{{ Auth::user()->first_name }}" required="required" class="form-control" placeholder="Enter First Name">
                                                <small id="first_nameError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="surname">Last Name <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" name="surname" value="{{ Auth::user()->surname }}" required="required" class="form-control" placeholder="Enter Last Name">
                                                <small id="surnameError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Email Address -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email Address <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="email" name="email" value="{{ Auth::user()->email }}" required="required" class="form-control" placeholder="Enter Email Address">
                                                <small id="emailError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Profile Photo -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="photo">Profile Photo</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="file" name="photo" class="form-control">
                                                @if (!empty(Auth::user()->photo))
                                                    <img src="{{ asset(Auth::user()->photo) }}" alt="Profile Photo" style="max-width: 100px; margin-top: 10px;">
                                                @endif
                                                <small id="photoError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="ln_solid"></div>
                                        <div class="item form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <button class="btn btn-primary" type="submit" name="updateUserProfile">
                                                    Update
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
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="opass">Old Password <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="password" name="opass" required="required" class="form-control" placeholder="Enter Old Password">
                                                <small id="opassError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- New Password -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="npass">New Password <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="password" name="npass" required="required" class="form-control" placeholder="Enter New Password">
                                                <small id="npassError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Confirm New Password -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="cpass">Re-enter New Password <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="password" name="cpass" required="required" class="form-control" placeholder="Enter New Password Again">
                                                <small id="cpassError" class="form-text text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="ln_solid"></div>
                                        <div class="item form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <button class="btn btn-primary" type="submit" name="userPassReset">
                                                    Reset
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
