@extends('layouts.app') <!-- Assuming a master layout file -->
@section('title', 'Fuel Prices')

@section('content')
    <div class="container searchbar">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0" data-aos="fade-right" style=""></div>
            <div class="col-lg-6 mb-6 mb-lg-0" data-aos="fade-right" style="">
                <input type="text" class="form-control" id="searchadd" placeholder="Search By Address">
            </div>
            <div class="col-lg-3 mb-3 mb-lg-0" data-aos="fade-right" style="">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#fuelPriceModal">Add Fuel Price</button>
            </div>
        </div>
    </div>

    <div id="showresults"></div>

    <!-- Modal -->
    <div class="modal fade" id="fuelPriceModal" tabindex="-1" role="dialog" aria-labelledby="fuelPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fuelPriceModalLabel">Add Fuel Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('fuel_prices.store') }}" enctype="multipart/form-data" id="addFuelPrice" class="form-horizontal form-label-left">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="purchase_date">Purchase Date</label>
                                <input type="date" class="form-control" name="purchase_date" id="purchase_date" placeholder="Purchase Date">
                                <small id="purchaseDateError" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="purchase_time">Purchase Time</label>
                                <input type="time" class="form-control" name="purchase_time" id="purchase_time" placeholder="Purchase Time">
                                <small id="purchaseTimeError" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="litres">Litres</label>
                                <input type="number" step="0.01" class="form-control" name="litres" id="litres" placeholder="Litres">
                                <small id="litresError" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="amount">Amount</label>
                                <input type="number" step="0.01" class="form-control" name="amount" id="amount" placeholder="Amount">
                                <small id="amountError" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="+810000000000">
                            <small id="phoneNumberError" class="form-text text-danger"></small>
                        </div>
                        @if($stations->count() > 0)
                            <div class="form-group">
                                <label for="station_id">Select Station</label>
                                <select class="form-control" id="station_id" name="station_id">
                                    <option value="0">Select Station</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->station_name }}</option>
                                    @endforeach
                                </select>
                                <small id="stationIdError" class="form-text text-danger"></small>
                            </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="attachment" id="attachment">
                            <label class="custom-file-label" for="attachment">Upload Photo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "{{ route('fuel_prices.results') }}",
                data: {action: 'alertquerydplans', _token: '{{ csrf_token() }}' },
                success: function (result) {
                    if($.trim(result) != ""){
                        $('#showresults').html(result);
                    }
                }
            });

            $("#searchadd").keyup(function(){
                var searchadd = $("#searchadd").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('fuel_prices.results') }}",
                    data: {searchadd: searchadd, action: 'alertquerydplans', _token: '{{ csrf_token() }}' },
                    success: function (result) {
                        if($.trim(result) != ""){
                            $('#showresults').html(result);
                        }
                    }
                });
            });
        });
    </script>
@endpush
