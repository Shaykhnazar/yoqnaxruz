{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <section id="features" class="features" style="margin-top: 20px; padding-bottom: 0px !important;">
        <div class="container">
            <div class="row">
                <div class="section-content" style="margin-left: auto; margin-right: auto;">
                    <div class="">
                        <h1 class="pb-3" style="font-size:24px;">Register</h1>
                    </div>
                    <form method="POST" id="registerForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            {{-- Hidden input for title --}}
                            <input type="hidden" name="title" value="0">

                            <div class="form-group col-md-6">
                                <label for="first_name">First Name<span class="required">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                                <small id="firstNameError" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name">Last Name<span class="required">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                <small id="lastNameError" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email<span class="required">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address">
                            <small id="emailError" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="password">Password<span class="required">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                            <small id="passwordError" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password<span class="required">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" placeholder="Confirm password">
                            <small id="confirmPasswordError" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="role_id">Role<span class="required">*</span></label>
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="">Select a role</option>
                                <option value="3">User</option>
                                <option value="4">Station Manager</option>
                            </select>
                            <small id="roleError" class="form-text text-danger"></small>
                        </div>

                        {{-- Uncomment and include additional fields if needed --}}
                        {{--
                        <div class="form-group">
                          <label for="street_address">Street Address<span class="required">*</span></label>
                          <input type="text" class="form-control" id="street_address" name="street_address" placeholder="Enter street address">
                          <small id="streetAddressError" class="form-text text-danger"></small>
                        </div>
                        --}}

                        <div class="form-group">
                            <input type="hidden" name="form_type" value="register">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </section>

    <style>
        #registerForm label .required {
            color: red;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                let valid = true;

                // Clear previous errors
                $('#firstNameError').text('');
                $('#lastNameError').text('');
                $('#emailError').text('');
                $('#passwordError').text('');
                $('#confirmPasswordError').text('');
                $('#roleError').text('');

                // First Name validation
                const firstName = $('#first_name').val().trim();
                if (firstName === '') {
                    $('#firstNameError').text('First Name is required');
                    valid = false;
                }

                // Last Name validation
                const lastName = $('#last_name').val().trim();
                if (lastName === '') {
                    $('#lastNameError').text('Last Name is required');
                    valid = false;
                }

                // Email validation
                const email = $('#email').val().trim();
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email === '') {
                    $('#emailError').text('Email is required');
                    valid = false;
                } else if (!emailPattern.test(email)) {
                    $('#emailError').text('Invalid email format');
                    valid = false;
                }

                // Password validation
                const password = $('#password').val().trim();
                if (password === '') {
                    $('#passwordError').text('Password is required');
                    valid = false;
                } else if (password.length < 6) {
                    $('#passwordError').text('Password must be at least 6 characters long');
                    valid = false;
                }

                // Confirm Password validation
                const confirmPassword = $('#confirm_password').val().trim();
                if (confirmPassword === '') {
                    $('#confirmPasswordError').text('Confirm Password is required');
                    valid = false;
                } else if (password !== confirmPassword) {
                    $('#confirmPasswordError').text('Passwords do not match');
                    valid = false;
                }

                // Role validation
                const role = $('#role_id').val().trim();
                if (role === '') {
                    $('#roleError').text('Role is required');
                    valid = false;
                }

                if (valid) {
                    const formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('register.submit') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#registerForm')[0].reset();
                            alert(response.message);
                            window.location.href = '{{ route('login') }}';
                        },
                        error: function(jqXHR) {
                            if (jqXHR.status === 422) {
                                let errors = jqXHR.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    $('#' + key.charAt(0).toUpperCase() + key.slice(1) + 'Error').text(value[0]);
                                });
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
