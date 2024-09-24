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

    <div class="containercc">
        <div class="row">
            <div class="col-md-3 cl-xs-12 sidebarUSER2">
                <div class="mb-3 mb-lg-0" style="overflow-y: scroll; height: 616px;">
                    <ul class="nav nav-tabs flex-column" id="showresults">
                    </ul>
                </div>
            </div>
            <div class="col-md-9 cl-xs-12 rightUSER">
                <div class=" ml-auto" data-aos="fade-left"  >
                    <div class="tab-content">
                        <div class="tab-pane active show" id="">
                            <figure>
                                <div id="map">

                                </div>
                            </figure>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Features Section -->
    @include('partials.add_modal')

@endsection

@push('scripts')
    <script>
        console.log('ready');

        var map;
        var InforObj = [];
        var markersOnMap = [];

        // Initialize the map
        window.initMap = function() {
            // Ensure the #map element exists before initializing the map
            var mapElement = document.getElementById('map');
            if (!mapElement) {
                console.log('Map element not found');
                return;
            }

            var centerCords = { lat: 0, lng: 0 }; // Default center

            if (markersOnMap.length > 0) {
                centerCords = markersOnMap[0].LatLng; // Center on first marker
            }

            map = new google.maps.Map(mapElement, {
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

                // marker.set('infowindow', infowindow);
                infowindow.open(marker.get('map'), marker);
                InforObj[0] = infowindow;

                marker.addListener('click', function () {
                    // closeOtherInfo();
                    infowindow.open(map, marker);
                    InforObj[0] = infowindow;
                });

                marker.addListener('mouseover', function () {
                    updatePriceListByVisibleMarkers();

                });
                marker.addListener('mouseout', function () {
                    updatePriceListByVisibleMarkers();
                });

                // You can also listen for zoom or drag events on the map to update the price list
                google.maps.event.addListener(map, 'bounds_changed', function() {
                    updatePriceListByVisibleMarkers();
                });
            });
        }


        // Function to update the price list based on visible markers
        function updatePriceListByVisibleMarkers() {
            // Get current map bounds (visible area)
            var bounds = map.getBounds();

            // Filter markers that are within the current bounds
            var visibleMarkers = markersOnMap.filter(function(markerData) {
                var position = new google.maps.LatLng(markerData.LatLng.lat, markerData.LatLng.lng);
                return bounds.contains(position);
            });

            // Render the visible markers' prices in the sidebar
            makeVisiblePricesUpdate(visibleMarkers);
        }


        // Function to render only the visible prices
        function makeVisiblePricesUpdate(visibleMarkers) {
            // Create a Set of visible marker IDs for easy lookup
            var visibleMarkerIds = new Set(visibleMarkers.map(function(marker) {
                return marker.idofmap;
            }));

            // Get all sidebar items
            var allSidebarItems = document.querySelectorAll('.sidebara');

            // // Loop through all sidebar items
            allSidebarItems.forEach(function(sidebarItem) {
                // Extract the station ID from the sidebar item's class name
                var stationId = sidebarItem.className.match(/sidebar(\d+)/)[1];

                // Check if the station ID exists in the visible markers set
                if (visibleMarkerIds.has(parseInt(stationId))) {
                    // If the station ID is in the visible markers, show the item
                    // sidebarItem.parentElement.style.display = 'block';
                    sidebarItem.style.display = 'block';
                } else {
                    // If the station ID is not in the visible markers, hide the item
                    // sidebarItem.parentElement.style.display = 'none';
                    sidebarItem.style.display = 'none';
                }
            });
        }


        // function myFunction(p1){
        //     // alert(p1);
        //     //jQuery(".sidebarcontents").hide();
        //     //document.getElementsByClassName("sidebarcontents").style.visibility = 'hidden';
        //     /*var y =document.getElementsByClassName("sidebarcontents");
        //     x.style.display = "none";*/
        //     for (var h = 0; h < markersOnMap.length; h++) {
        //         document.getElementsByClassName('sidebarcontents')[h].style.display = 'none';
        //         document.getElementsByClassName('sidebara')[h].style.display = 'none';
        //     }
        //     var x = document.getElementsByClassName("sidebarcontent"+p1)[0];
        //     x.style.display = "block";
        // }
        // Close any open InfoWindow
        function closeOtherInfo() {
            if (InforObj.length > 0) {
                /* detach the info-window from the marker ... undocumented in the API docs */
                InforObj[0].set("marker", null);
                /* and close it */
                InforObj[0].close();
                /* blank the array */
                InforObj.length = 0;
            }
        }


        // Initialize Autocomplete
        window.initAutocomplete = function() {
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
            var html = '';
            markersOnMap = []; // Reset markers

            prices.forEach(function(price) {
                var geolocation = price.geolocation ? price.geolocation.split(',') : [0, 0];
                var lat = parseFloat(geolocation[0]);
                var lng = parseFloat(geolocation[1]);

                // Add to markersOnMap array
                markersOnMap.push({
                    placeName: `<div class='pumpbefore6am'>${price.before6amprice}</div><div class='pumpafter6am'>${price.after6amprice}</div><div class='pumpname'>${price.station_name}</div>`,
                    LatLng: { lat: lat, lng: lng },
                    idofmap: price.id
                });

                // Sidebar content
                html += makePriceItem(price);
            });
            // Inject HTML
            $('#showresults').html(html);

            // Now that the map container (#map) is in the DOM, initialize the map
            initMap();

            // Attach event listeners
            attachEventListeners();
        }

        function makePriceItem(price) {
            return `
                    <li class="nav-item${price.id}">
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
                                <a class='btn btn-danger' style="background: rebeccapurple;width: 100%;" target="_blank" href='https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(price.geolocation)}'>
                                    Get Directions
                                </a>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <a class='btn btn-danger' style="background: #299ef4;width: 100%;" href='#'>
                                    Update Prices
                                </a>
                            </div>
                        </div>
                    </div>
            `
        }

        // Attach event listeners for sidebar navigation using event delegation
        function attachEventListeners() {
            // Handle sidebar item clicks
            $(document).on('click', '.sidebara', function() {
                var stationId = $(this).attr('class').match(/sidebar(\d+)/)[1];

                // Hide all .nav-item elements (sidebar list items)
                // $('.nav-item').hide();

                $(".sidebara").hide();

                // Hide all .sidebarcontents elements (detailed content)
                $('.sidebarcontents').hide();

                // Show the specific sidebarcontent for the clicked station
                $('.sidebarcontent' + stationId).show();
            });

            // Handle back button clicks using delegation
            $(document).on('click', '.backbtn', function() {
                // Hide all .sidebarcontents elements
                $('.sidebarcontents').hide();

                // $(".sidebara").show();

                updatePriceListByVisibleMarkers();

                // Show all .nav-item elements (restore the sidebar list)
                // $('.nav-item').show();
            });

            // Handle marker content clicks
            $(document).on('click', '.contentmarker', function() {
                var id = $(this).attr('id').replace('content', '');

                // Hide all .nav-item elements (sidebar list items)
                // $('.nav-item').hide();

                $(".sidebara").hide();

                // Hide all .sidebarcontents elements
                $('.sidebarcontents').hide();

                // Show the specific sidebarcontent for the clicked marker
                $('.sidebarcontent' + id).show();
            });
        }

        window.onload = function() {
            fetchPrices();
        }

        $(document).ready(function(){
            // Search by address
            $("#searchadd").keyup(function(){
                var searchadd = $("#searchadd").val();
                fetchPrices(searchadd);
            });
        });
    </script>
        <!-- Google Maps and Places API -->
    {{--<script src="https://maps.googleapis.com/maps/api/js?key={{ $GOOGLE_MAPS_API_KEY }}&libraries=places&callback=initAutocomplete" async defer></script>--}}
    <script src="https://maps.gomaps.pro/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap" async defer onerror="handleMapError()"></script>

    <script>
        function handleMapError() {
            alert('Failed to load Google Maps. Please try again later.');
        }
    </script>
@endpush
