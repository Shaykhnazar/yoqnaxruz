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

    <div id="showresults">
        <div class="col-md-9 cl-xs-12 rightUSER">
            <div class="ml-auto">
                <div class="tab-content">
                    <div class="tab-pane active show" id="">
                        <figure>
                            <div id="map"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.add_modal')

@endsection

@push('scripts')
    <script>
        console.log('ready');

        var map;
        var InforObj = [];
        var markersOnMap = [];

        // Initialize the map
        function initMap() {
            var centerCords = { lat: 0, lng: 0 }; // Default center

            if (markersOnMap.length > 0) {
                centerCords = markersOnMap[0].LatLng; // Center on first marker
            }

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: centerCords
            });

            addMarkerInfo();
        }

        // Add markers to the map
        function addMarkerInfo() {
            markersOnMap.forEach(function(markerData) {
                var contentString = `
                    <div style="cursor: pointer;" class="contentmarker" onclick="myFunction(${markerData.idofmap})" id="content${markerData.idofmap}">
                        ${markerData.placeName}
                    </div>
                `;

                var marker = new google.maps.Marker({
                    position: markerData.LatLng,
                    map: map
                });

                var infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 200
                });

                marker.addListener('click', function () {
                    closeOtherInfo();
                    infowindow.open(map, marker);
                    InforObj[0] = infowindow;
                });
            });
        }

        // Initialize Autocomplete
        function initAutocomplete() {
            var autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('searchadd'),
                { types: ['geocode'] }
            );

            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    alert("No details available for input: '" + place.name + "'");
                    return;
                }

                map.setCenter(place.geometry.location);
                map.setZoom(17);

                // Optionally, add a marker for the selected place
                var marker = new google.maps.Marker({
                    map: map,
                    position: place.geometry.location
                });
            });
        }

        // Fetch and render prices
        function fetchPrices(searchadd = '') {
            $.ajax({
                type: "POST",
                url: "{{ route('fuel_prices.results') }}",
                data: { searchadd: searchadd, _token: '{{ csrf_token() }}' },
                success: function (response) {
                    // console.log(response.prices);
                    if (response.prices.length > 0) {
                        renderPrices(response.prices);
                        renderMap();
                    } else {
                        $('#showresults').html('<p style="text-align:center;margin-top:200px;color:red;font-weight:900">No Data Found</p>');
                        if (map) {
                            map.setCenter({ lat: 0, lng: 0 });
                        }
                    }
                },
                error: function () {
                    alert('An error occurred while fetching data.');
                }
            });
        }

        // Render prices in the sidebar and set markers
        function renderPrices(prices) {
            var html = '<div class="containercc"><div class="row"><div class="col-md-3 cl-xs-12 sidebarUSER2"><div class="mb-3 mb-lg-0" style="overflow-y: scroll; height: 616px;"><ul class="nav nav-tabs flex-column">';
            markersOnMap = []; // Reset markers

            prices.forEach(function(price) {
                var geolocation = price.geolocation ? price.geolocation.split(',') : [0, 0];
                var lat = parseFloat(geolocation[0]);
                var lng = parseFloat(geolocation[1]);

                // Add to markersOnMap array
                markersOnMap.push({
                    placeName: `<div class='fuelprice'>${price.price}</div><div class='fueltype'>${price.fuel_type}</div><div class='stationname'>${price.station_name}</div>`,
                    LatLng: { lat: lat, lng: lng },
                    idofmap: price.id
                });

                // Sidebar content
                html += `
                    <li class="nav-item">
                        <a class="nav-link active show sidebara sidebar${price.id}" data-toggle="tab" href="#tab-${price.id}">
                        <h4 style="    margin-bottom: 0px;">${price.before6amprice}</h4>
                        <small>Before 6am</small>
                        <h1></h1>
                        <h4 style="    margin-bottom: 0px;">${price.after6amprice}</h4>
                        <small>After 6am</small>
                            <p style="font-weight: 900;"><i class="fa fa-location"></i> ${price.station_name}</p>
                            <p style="font-size:10px"><i class="fa fa-location"></i> ${price.street_address}</p>
                        </a>
                    </li>
                    <div class="sidebarcontents sidebarcontent${price.id}" style="padding:15px; border:none; background: transparent; display:none">
                        <div class="row">
                            <div class="col-sm-4" style="margin-top:15px;margin-bottom:15px">
                                <button class="btn btn-primary backbtn" style="font-size: 11px;line-height: 0.5;border:1px solid lightgrey">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                                </button>
                            </div>
                            <div class="col-sm-8" style="margin-top:15px;margin-bottom:15px">
                                <p>${price.station_name}</p>
                            </div>
                            <div class="col-sm-12" style="border-top:1px solid lightgrey;border-bottom:1px solid lightgrey">
                                <p style="margin-bottom: 0px;padding-top: 10px;padding-bottom:10px">
                                    <i class="fa fa-location-arrow"></i> ${price.street_address}
                                </p>
                            </div>
                            <div class="col-sm-12" style="border-top:1px solid lightgrey;border-bottom:1px solid lightgrey">
                                <p style="margin-bottom: 0px;padding-top: 10px;padding-bottom:10px">
                                    <i class="fa fa-phone" aria-hidden="true"></i> ${price.phone_no}
                                </p>
                            </div>
                        </div>

                       <div class="row" style="margin-top:15px;margin-bottom:15px;">
                          <div class="col-sm-12" style=""><h4 style="margin-bottom: 0px;font-family: sans-serif;font-size: 18px;font-weight: 700;padding-bottom:20px">ULP prices</h4>

                          </div>
                          <div class="col-sm-6" style="text-align: center;"><h4 style="    margin-bottom: 0px;    font-family: sans-serif;">${price.before6amprice}</h4>
                             <small>Before 6am</small>
                           </div>


                          <div class="col-sm-6" style="text-align: center;"><h4 style="    margin-bottom: 0px;    font-family: sans-serif;">${price.after6amprice}</h4>
                            <small>After 6am</small>
                          </div>

                        </div>
                        <div class="row" style="padding-top:30px;padding-bottom:30px;border-top:1px solid lightgrey;border-bottom:1px solid lightgrey;">
                            <div class="col-sm-12">
                                <a class='btn btn-danger' style="background: rebeccapurple;width: 100%;" target="_blank" href='https://maps.google.com/?q=${encodeURIComponent(price.street_address)}'>
                                    Get Directions
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += '</ul></div></div><div class="col-md-9 cl-xs-12 rightUSER"><div class="ml-auto"><div class="tab-content"><div class="tab-pane active show" id=""><figure><div id="map"></div></figure></div></div></div></div></div>';

            $('#showresults').html(html);

            // Attach event listeners
            attachEventListeners();
        }

        // Attach event listeners for sidebar navigation
        function attachEventListeners() {
            $('.sidebara').click(function(){
                var stationId = $(this).attr('class').match(/sidebar(\d+)/)[1];
                $('.sidebarcontents').hide();
                $('.sidebarcontent' + stationId).show();
            });

            $('.backbtn').click(function(){
                $('.sidebarcontents').hide();
                $('.sidebara').show();
            });

            $('.contentmarker').click(function(){
                var id = $(this).attr('id').replace('content', '');
                $('.sidebarcontents').hide();
                $('.sidebarcontent' + id).show();
            });
        }

        // Render the map after prices are loaded
        function renderMap() {
            if (typeof initMap === 'function') {
                initMap();
                initAutocomplete();
            }
        }

        $(document).ready(function(){
            // Search by address
            $("#searchadd").keyup(function(){
                var searchadd = $("#searchadd").val();
                fetchPrices(searchadd);
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

        window.onload = function () {
            // Initial load
            fetchPrices();
        }
    </script>
    <script>
{{--        @php--}}
{{--            // Extract latitude and longitude from the first price's geolocation if available--}}
{{--            $firstPrice = $prices->first();--}}
{{--            if ($firstPrice && $firstPrice->geolocation) {--}}
{{--                $coords = explode(',', $firstPrice->geolocation);--}}
{{--                $centerLat = isset($coords[0]) ? floatval($coords[0]) : 0;--}}
{{--                $centerLng = isset($coords[1]) ? floatval($coords[1]) : 0;--}}
{{--            }--}}
{{--        @endphp--}}

{{--        var map;--}}
{{--        var InforObj = [];--}}
{{--        var centerCords = {--}}
{{--            lat: {{ $centerLat }},--}}
{{--            lng: {{ $centerLng }}--}}
{{--        };--}}
{{--        var markersOnMap = [--}}
{{--            @foreach($prices as $price)--}}
{{--                @php--}}
{{--                    if ($price->geolocation) {--}}
{{--                        $coords = explode(',', $price->geolocation);--}}
{{--                        $lat = isset($coords[0]) ? floatval($coords[0]) : 0;--}}
{{--                        $lng = isset($coords[1]) ? floatval($coords[1]) : 0;--}}
{{--                    } else {--}}
{{--                        $lat = 0;--}}
{{--                        $lng = 0;--}}
{{--                    }--}}
{{--                @endphp--}}
{{--            {--}}
{{--                placeName: "<div class='fuelprice'>{{ $price->price }}</div><div class='fueltype'>{{ $price->fuel_type }}</div><div class='stationname'>{{ $price->station_name }}</div>",--}}
{{--                LatLng: [{--}}
{{--                    lat: {{ $lat }},--}}
{{--                    lng: {{ $lng }}--}}
{{--                }],--}}
{{--                idofmap: {{ $price->id }}--}}
{{--            },--}}
{{--            @endforeach--}}
{{--        ];--}}

{{--        function initMap() {--}}
{{--            // Initialize the map only if the #map div exists--}}
{{--            if (document.getElementById('map')) {--}}
{{--                map = new google.maps.Map(document.getElementById('map'), {--}}
{{--                    zoom: 17,--}}
{{--                    center: centerCords--}}
{{--                });--}}
{{--                addMarkerInfo();--}}
{{--                // initAutocomplete();--}}
{{--            }--}}
{{--        }--}}

{{--        window.onload = function () {--}}
{{--            initMap();--}}
{{--        };--}}

{{--        function addMarkerInfo(map) {--}}
{{--            markersOnMap.forEach(function(markerData) {--}}
{{--                var contentString = `--}}
{{--                <div style="cursor: pointer;" class="contentmarker" onclick="myFunction(${markerData.idofmap})" id="content${markerData.idofmap}">--}}
{{--                    ${markerData.placeName}--}}
{{--                </div>--}}
{{--            `;--}}

{{--                var marker = new google.maps.Marker({--}}
{{--                    position: markerData.LatLng[0],--}}
{{--                    map: map--}}
{{--                });--}}

{{--                var infowindow = new google.maps.InfoWindow({--}}
{{--                    content: contentString,--}}
{{--                    maxWidth: 200--}}
{{--                });--}}

{{--                marker.addListener('click', function () {--}}
{{--                    closeOtherInfo();--}}
{{--                    infowindow.open(map, marker);--}}
{{--                    InforObj[0] = infowindow;--}}
{{--                });--}}
{{--            });--}}
{{--        }--}}


{{--        function myFunction(id){--}}
{{--            $('.sidebarcontents').hide();--}}
{{--            $('.sidebarcontent' + id).show();--}}
{{--        }--}}

{{--        $(document).on('click', '.backbtn', function(){--}}
{{--            $('.sidebarcontents').hide();--}}
{{--            $('.sidebara').show();--}}
{{--        });--}}

{{--        $(document).on('click', '.contentmarker', function(){--}}
{{--            var id = $(this).attr('id').replace('content', '');--}}
{{--            $('.sidebarcontents').hide();--}}
{{--            $('.sidebarcontent' + id).show();--}}
{{--        });--}}

{{--        function closeOtherInfo() {--}}
{{--            if (InforObj.length > 0) {--}}
{{--                /* detach the info-window from the marker ... undocumented in the API docs */--}}
{{--                InforObj[0].set("marker", null);--}}
{{--                /* and close it */--}}
{{--                InforObj[0].close();--}}
{{--                /* blank the array */--}}
{{--                InforObj.length = 0;--}}
{{--            }--}}
{{--        }--}}

{{--        function initAutocomplete() {--}}
{{--            // Initialize autocomplete for the address input--}}
{{--            var autocomplete = new google.maps.places.Autocomplete(--}}
{{--                document.getElementById('search_google'),--}}
{{--                { types: ['geocode'] }--}}
{{--            );--}}

{{--            autocomplete.addListener('place_changed', function () {--}}
{{--                var place = autocomplete.getPlace();--}}
{{--                if (!place.geometry) {--}}
{{--                    alert("No details available for input: '" + place.name + "'");--}}
{{--                    return;--}}
{{--                }--}}

{{--                map.setCenter(place.geometry.location);--}}
{{--                map.setZoom(17);--}}

{{--                // Optionally, add a marker for the selected place--}}
{{--                var marker = new google.maps.Marker({--}}
{{--                    map: map,--}}
{{--                    position: place.geometry.location--}}
{{--                });--}}
{{--            });--}}
{{--        }--}}
    </script>

    @php
        $GOOGLE_MAPS_API_KEY = env('GOOGLE_MAPS_API_KEY');
    @endphp

        <!-- Google Maps and Places API -->
    {{--<script src="https://maps.googleapis.com/maps/api/js?key={{ $GOOGLE_MAPS_API_KEY }}&libraries=places&callback=initAutocomplete" async defer></script>--}}
    <script src="https://maps.gomaps.pro/maps/api/js?key={{ $GOOGLE_MAPS_API_KEY }}&libraries=places&callback=initMap" async defer onerror="handleMapError()"></script>

    <script>
        function handleMapError() {
            alert('Failed to load Google Maps. Please try again later.');
        }
    </script>
@endpush
