@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section id="features" class="features" style="margin-top: 20px; padding-bottom: 0px !important;">
        <div class="container">
            <div class="row">
                <div class="mt-5" style="margin-left: auto; margin-right: auto; width: 500px; margin-bottom: 200px;">
                    <div class="">
                        <h1>Login</h1>
                    </div>
                    <form method="POST" id="loginForm">
                        @csrf
                        <small id="loginError" class="form-text text-danger"></small>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                            <small id="emailError" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                            <small id="passwordError" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <input type="hidden" value="login" name="form_type">
                            <input type="submit" class="btn btn-primary mt-3" value="Submit">
                        </div>
                    </form>
                    <p>Not an existing user? Please <a href="{{ route('register') }}">Register</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault();

                let valid = true;

                // Clear previous errors
                $('#emailError').text('');
                $('#passwordError').text('');
                $('#loginError').text('');

                // Email validation
                const email = $('#email').val().trim();
                if (email === '') {
                    $('#emailError').text('Email is required');
                    valid = false;
                }

                // Password validation
                const password = $('#password').val().trim();
                if (password === '') {
                    $('#passwordError').text('Password is required');
                    valid = false;
                }

                if (valid) {
                    const formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('login') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                window.location.href = '{{ url('userprofile') }}';
                            } else {
                                $('#loginError').text(response.message);
                            }
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
                }
            });
        });
    </script>
@endpush
