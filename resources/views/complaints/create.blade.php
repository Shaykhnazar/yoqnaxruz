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
                <div class="col-md-10 col-xs-12">
                    <div class="section-content">
                        <div class="col-12">
                            <h1 class="pb-3" style="font-size:24px;">Help Desk</h1>
                        </div>
                        <form method="POST" id="complaintForm" enctype="multipart/form-data" action="{{ route('complaints.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="station_id">Select Station</label>
                                <select class="form-control" id="station" name="station" required>
                                    <option value="">Select Station</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->station_name }} - {{ $station->city }}</option>
                                    @endforeach
                                </select>
                                <small id="stationError" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                                <small id="titleError" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea class="form-control" name="comment" id="comment" rows="5" required></textarea>
                                <small id="commentError" class="form-text text-danger"></small>
                            </div>

                            <div class="custom-file mb-2">
                                <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                <label class="custom-file-label" for="attachment">Upload Photo (optional)</label>
                                <small id="attachmentError" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="status" value="pending">
                                <input type="submit" class="btn btn-primary mt-3" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
