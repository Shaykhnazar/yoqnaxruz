@extends('layouts.app')

@section('title', 'Fuel Prices')

@section('content')
    <div class="container searchbar">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0"></div>
            <div class="col-lg-6 mb-6 mb-lg-0">
                <input type="text" class="form-control" id="searchadd" placeholder="Search By Address">
            </div>
            <div class="col-lg-3 mb-3 mb-lg-0">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#fuelPriceModal">Add Fuel Price</button>
            </div>
        </div>
    </div>

    <div id="showresults"></div>

    @include('partials.add_modal', ['stations' => $stations])

@endsection

@push('scripts')
    <script>
        console.log('ready');

        $(document).ready(function(){
            // Initial load
            $.ajax({
                type: "POST",
                url: "{{ route('fuel_prices.results') }}",
                data: {_token: '{{ csrf_token() }}' },
                success: function (result) {
                    console.log(result);
                    if($.trim(result) !== "") {
                        $('#showresults').html(result);
                    }
                }
            });

            // Search by address
            $("#searchadd").keyup(function(){
                var searchadd = $("#searchadd").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('fuel_prices.results') }}",
                    data: {searchadd: searchadd, _token: '{{ csrf_token() }}' },
                    success: function (result) {
                        if($.trim(result) != "") {
                            $('#showresults').html(result);
                        }
                    }
                });
            });

            // Handle form submission
            $('#addFuelPrice').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('fuel_prices.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#addFuelPrice')[0].reset();
                        $('#fuelPriceModal').modal('hide');
                        alert(response.message);
                    },
                    error: function(jqXHR) {
                        if(jqXHR.status === 422) {
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
