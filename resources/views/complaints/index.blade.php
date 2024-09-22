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
                    <div class="section-content">
                        <div class="col-12">
                            <h1 class="pb-3" style="font-size:24px;">Tickets</h1>
                        </div>
                        @if($complaints->isNotEmpty())
                            <table class="table table-responsive table-striped table-bordered tablewhite" style="max-height: 400px; overflow-y: auto;">
                                <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Complaint ID</th>
                                    <th>Station ID</th>
                                    <th>Description</th>
                                    <th>Date Logged</th>
                                    <th>Time</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($complaints as $index => $complaint)
                                    <tr data-toggle="modal" data-target=".complaint-modal-{{ $complaint->id }}" style="cursor:pointer">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $complaint->complaint_id }}</td>
                                        <td>{{ $complaint->station_id }}</td>
                                        <td>{{ $complaint->complainant }}</td>
                                        <td>{{ $complaint->date_logged }}</td>
                                        <td>{{ $complaint->time }}</td>
                                        <td>
                                            @if($complaint->attachments)
                                                <img src="{{ asset('storage/'.$complaint->attachments) }}" width="100px" />
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td><span class="badge badge-primary">View</span></td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade complaint-modal-{{ $complaint->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" style="max-width:650px;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Help Desk Comments</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-4">
                                                        <div class="col-lg-12">
                                                            @if($complaint->attachments)
                                                                <img src="{{ asset('storage/'.$complaint->attachments) }}" width="auto" />
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <p><strong>User Name: </strong>{{ $complaint->user->name ?? 'N/A' }}</p>
                                                        <p><strong>Date: </strong>{{ \Carbon\Carbon::parse($complaint->date_logged)->format('d-m-Y h:i A') }}</p>
                                                        <div class="col-lg-12 comentSection">
                                                            <h5>Title: {{ $complaint->title }}</h5>
                                                            <p class="Usercoment">Comment: {{ $complaint->complainant }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <div class="col-lg-12">
                                                            @foreach($complaint->replies as $reply)
                                                                <div class="{{ $reply->reply_by }}reply_admin">
                                                                    <p class="{{ $reply->reply_by }}Comment adminreplywrap">
                                                                        {{ $reply->reply_by }}: {{ $reply->comment }}
                                                                    </p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <div class="col-lg-12">
                                                            @if($complaint->status == 'pending')
                                                                <form method="POST" action="{{ route('complaints.reply', $complaint->id) }}">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <textarea class="form-control" name="comment" rows="5" required placeholder="Write your reply here"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <p>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        @if($complaint->status == 'closed')
                                                            <button type="button" class="btn btn-danger">Closed</button>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Modal -->
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center">No complaints to display</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .comentSection h5 {
            color: #000;
            padding-left: 10px;
            font-size: 16px;
            font-weight: bold;
            padding: 10px;
        }
        .reply_admin {
            float: right;
            clear: both;
        }
        .Usercoment {
            border-radius: 0px 20px 20px 20px;
            margin-top: 5px;
            background: #afdbf3;
        }
        .AdminComment {
            background: #c3fcf3;
            border-radius: 20px 0px 20px 20px;
            margin-top: 5px;
        }
        .comentSection {
            padding: 10px 0px;
            border-radius: 5px;
        }
        .Adminreply_admin {
            clear: both;
            width: auto;
            display: flex;
            float: right;
            max-width: 75%;
        }
        .modal-content p {
            margin-bottom: 0px;
            color: #000;
            padding-bottom: 5px;
            float: left;
            font-size: 14px;
            padding: 8px 10px;
        }
        .badge-danger {
            padding: 10px;
        }
        .badge-primary {
            padding: 10px;
        }
        .Userreply_admin {
            clear: both;
        }
    </style>
@endsection
