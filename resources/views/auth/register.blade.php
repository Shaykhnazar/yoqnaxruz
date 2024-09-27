@extends('layouts.app')

@section('title', __('site.register'))

@section('content')
    <section id="features" class="features">
        <div class="container">
            <div class="row">
                <div class="section-content" style="margin-left: auto; margin-right: auto;">
                    <div class="">
                        <h1 class="pb-3" style="font-size:24px;">{{ __('site.register') }}</h1>
                    </div>
                    <form method="POST" id="registerForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <input type="hidden" name="title" value="0">

                            <div class="form-group col-md-6">
                                <label for="first_name">{{ __('site.first_name') }}<span class="required">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{ __('site.first_name') }}">
                                <small id="firstNameError" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="surname">{{ __('site.last_name') }}<span class="required">*</span></label>
                                <input type="text" class="form-control" id="surname" name="surname" placeholder="{{ __('site.last_name') }}">
                                <small id="lastNameError" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('site.email') }}<span class="required">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('site.email') }}">
                            <small id="emailError" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('site.password') }}<span class="required">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('site.password') }}">
                            <small id="passwordError" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">{{ __('site.confirm_password') }}<span class="required">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" placeholder="{{ __('site.confirm_password') }}">
                            <small id="confirmPasswordError" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label>{{ __('site.role') }}<span class="required">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="roleUser" value="User" checked {{ old('role') == 'User' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="roleUser">{{ __('site.user_role') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="roleStationManager" value="Station Manager" {{ old('role') == 'Station Manager' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="roleStationManager">{{ __('site.station_manager_role') }}</label>
                                </div>
                            </div>
                            <small id="roleError" class="form-text text-danger">
                                @error('role') {{ $message }} @enderror
                            </small>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="form_type" value="register">
                            <button type="submit" class="btn btn-primary">{{ __('site.register.submit') }}</button>
                        </div>
                    </form>
                    <p>{{ __('site.already_have_account') }} <a href="{{ route('login') }}">{{ __('site.login') }}</a></p>
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
                    $('#firstNameError').text('{{ __('site.first_name_required') }}');
                    valid = false;
                }

                // Last Name validation
                const lastName = $('#surname').val().trim();
                if (lastName === '') {
                    $('#lastNameError').text('{{ __('site.last_name_required') }}');
                    valid = false;
                }

                // Email validation
                const email = $('#email').val().trim();
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email === '') {
                    $('#emailError').text('{{ __('site.email_required') }}');
                    valid = false;
                } else if (!emailPattern.test(email)) {
                    $('#emailError').text('{{ __('site.email_invalid') }}');
                    valid = false;
                }

                // Password validation
                const password = $('#password').val().trim();
                if (password === '') {
                    $('#passwordError').text('{{ __('site.password_required') }}');
                    valid = false;
                } else if (password.length < 6) {
                    $('#passwordError').text('{{ __('site.password_min') }}');
                    valid = false;
                }

                // Confirm Password validation
                const confirmPassword = $('#confirm_password').val().trim();
                if (confirmPassword === '') {
                    $('#confirmPasswordError').text('{{ __('site.confirm_password_required') }}');
                    valid = false;
                } else if (password !== confirmPassword) {
                    $('#confirmPasswordError').text('{{ __('site.password_mismatch') }}');
                    valid = false;
                }

                // Role validation
                const role = $('input[name="role"]:checked').val();

                if (!role) {
                    $('#roleError').text('{{ __('site.role_required') }}');
                    valid = false;
                } else {
                    $('#roleError').text(''); // Clear any previous error messages
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
