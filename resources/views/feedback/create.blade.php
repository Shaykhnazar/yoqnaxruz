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
                        <div class="col-12">
                            <h1 class="pb-3" style="font-size:24px;">User Feedback</h1>
                        </div>
                        <form method="POST" id="myForm" enctype="multipart/form-data">
                            @csrf
                            @if ($stations->count() > 0)
                                <div class="form-group">
                                    <label for="station">Select Station</label>
                                    <select class="form-control" id="station" name="station">
                                        <option value="">Select Station</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->station_name }} - {{ $station->city }}</option>
                                        @endforeach
                                    </select>
                                    <small id="stationError" class="form-text text-danger"></small>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                                <small id="titleError" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea class="form-control" name="comment" id="comment" rows="10" cols="30"></textarea>
                                <small id="commentError" class="form-text text-danger"></small>
                            </div>

                            <!-- Rating Stars -->
                            <style type="text/css">
                                .card2 {
                                    background: #fff;
                                    width: 100%;
                                }
                                .star {
                                    font-size: 10vh;
                                    cursor: pointer;
                                    display: inline-block;
                                }
                                .one {
                                    color: rgb(255, 0, 0);
                                }
                                .two {
                                    color: rgb(255, 106, 0);
                                }
                                .three {
                                    color: rgb(251, 255, 120);
                                }
                                .four {
                                    color: rgb(255, 255, 0);
                                }
                                .five {
                                    color: rgb(24, 159, 14);
                                }
                            </style>
                            <div class="form-group">
                                <div class="card2">
                                    <h1>Select Rating</h1>
                                    <span onclick="gfg(1)" class="star">★</span>
                                    <span onclick="gfg(2)" class="star">★</span>
                                    <span onclick="gfg(3)" class="star">★</span>
                                    <span onclick="gfg(4)" class="star">★</span>
                                    <span onclick="gfg(5)" class="star">★</span>
                                </div>
                                <input type="hidden" id="rating" name="rating" value="0"/>
                                <small id="ratingError" class="form-text text-danger"></small>
                            </div>
                            <script type="text/javascript">
                                var stars = document.getElementsByClassName("star");
                                function gfg(n) {
                                    remove();
                                    for (var i = 0; i < n; i++) {
                                        if (n == 1) cls = "one";
                                        else if (n == 2) cls = "two";
                                        else if (n == 3) cls = "three";
                                        else if (n == 4) cls = "four";
                                        else if (n == 5) cls = "five";
                                        stars[i].className = "star " + cls;
                                    }
                                    $("#rating").val(n);
                                }
                                function remove() {
                                    let i = 0;
                                    while (i < 5) {
                                        stars[i].className = "star";
                                        i++;
                                    }
                                }
                            </script>
                            <!-- End of Rating Stars -->

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                <label class="custom-file-label" for="attachment">Upload Photo</label>
                                <small id="attachmentError" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary mt-3" value="Submit">
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
        $(document).ready(function() {
            $('#myForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                let valid = true;

                // Clear previous errors
                $('#titleError').text('');
                $('#commentError').text('');
                $('#ratingError').text('');
                $('#attachmentError').text('');
                $('#stationError').text('');

                // Title validation
                const title = $('#title').val().trim();
                if (title === '') {
                    $('#titleError').text('Title is required');
                    valid = false;
                }

                // Comment validation
                const comment = $('#comment').val().trim();
                if (comment === '') {
                    $('#commentError').text('Comment is required');
                    valid = false;
                }

                // Rating validation
                const rating = $('#rating').val();
                if (rating === '0') {
                    $('#ratingError').text('Please select a rating');
                    valid = false;
                }

                // Station validation
                const station = $('#station').val();
                if (station === '') {
                    $('#stationError').text('Please select a station');
                    valid = false;
                }

                // Attachment validation
                const attachment = $('#attachment')[0].files[0];
                if (attachment && attachment.size > 2 * 1024 * 1024) { // 2MB limit
                    $('#attachmentError').text('File size must be less than 2MB');
                    valid = false;
                }

                if (valid) {
                    const formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('feedback.store') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#myForm')[0].reset();
                            alert(response.message);
                            // Optionally redirect or update the page
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
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
