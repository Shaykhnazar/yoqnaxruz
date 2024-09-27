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
                <div class="col-md-10 col-xs-12">
                    <div class="section-content">
                        <div class="col-12">
                            <h1 class="pb-3" style="font-size:24px;">{{ __('site.help_desk') }}</h1>
                        </div>
                        <form method="POST" id="complaintForm" enctype="multipart/form-data" action="{{ route('complaints.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="station_id">{{ __('site.select_station') }}</label>
                                <select class="form-control" id="station_id" name="station_id" style="width: 100%;">
                                    <!-- Options will be loaded via AJAX -->
                                </select>
                                <small id="station_idError" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="title">{{ __('site.field.common.title') }}</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="{{ __('site.field.common.title') }}" required>
                                <small id="titleError" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="comment">{{ __('site.comment') }}</label>
                                <textarea class="form-control" name="comment" id="comment" rows="5" required></textarea>
                                <small id="commentError" class="form-text text-danger"></small>
                            </div>

                            <div class="custom-file mb-2">
                                <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                <label class="custom-file-label" for="attachment">{{ __('site.upload_photo') }}</label>
                                <small id="attachmentError" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="status" value="pending">
                                <input type="submit" class="btn btn-primary mt-3" value="{{ __('site.submit') }}">
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
            // Initialize Select2 on the station select element
            $('#station_id').select2({
                placeholder: '{{ __('site.choose_station') }}',
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route('stations.find') }}',
                    dataType: 'json',
                    delay: 250,  // Wait 250ms before triggering the request
                    data: function (params) {
                        return {
                            q: params.term,  // Search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data,  // Return the data as results
                        };
                    },
                    cache: true,
                },
            });
        });
    </script>
@endpush
