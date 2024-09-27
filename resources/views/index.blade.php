@extends('layouts.app')

@section('title', __('site.title'))

@section('content')
    <div class="container searchbar">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0"></div>
            <div class="col-lg-6 mb-6 mb-lg-0">
                <input type="text" class="form-control" id="searchadd" placeholder="{{ __('site.search_by_address') }}">
            </div>
            <div class="col-lg-3 mb-3 mb-lg-0">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#fuelPriceModal">{{ __('site.add_fuel_price') }}</button>
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
        // Define localized strings to use in JavaScript
        const localizedStrings = {
            noDataFound: @json(__('site.no_data_found')),
            getDirections: @json(__('site.get_directions')),
            updatePrices: @json(__('site.update_prices')),
            loadingMapError: @json(__('site.loading_map_error')),
            ulpPrices: @json(__('site.ulp_prices')),
            today: @json(__('site.today')),
            tomorrow: @json(__('site.tomorrow')),
            back: @json(__('site.back')),
            fuelPrice: @json(__('site.fuel_price')),
            fuelType: @json(__('site.fuel_type')),
            address: @json(__('site.address')),
            addFuelPrice: @json(__('site.add_fuel_price')),
        };

        console.log('ready');

        var map;
        var InforObj = [];
        var markersOnMap = [];
        let selectedMarker = null; // Store the currently selected marker

        // Initialize the map
        window.initMap = function() {
            // Ensure the #map element exists before initializing the map
            var mapElement = document.getElementById('map');
            if (!mapElement) {
                console.log(localizedStrings.loadingMapError);
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
                    map: map,
                    icon: null,
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

                // marker.addListener('mouseover', function () {
                //     updatePriceListByVisibleMarkers();
                //
                // });
                // marker.addListener('mouseout', function () {
                //     updatePriceListByVisibleMarkers();
                // });

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

            // Render the visible markers' stations in the sidebar
            makeVisiblePricesUpdate(visibleMarkers);
        }


        // Function to render only the visible stations
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


        function myFunction(p1){
            // alert(p1);
            //jQuery(".sidebarcontents").hide();
            //document.getElementsByClassName("sidebarcontents").style.visibility = 'hidden';
            /*var y =document.getElementsByClassName("sidebarcontents");
            x.style.display = "none";*/
            for (var h = 0; h < markersOnMap.length; h++) {
                document.getElementsByClassName('sidebarcontents')[h].style.display = 'none';
                document.getElementsByClassName('sidebara')[h].style.display = 'none';
            }
            var x = document.getElementsByClassName("sidebarcontent"+p1)[0];
            x.style.display = "block";
        }
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
        // window.initAutocomplete = function() {
        //     var autocomplete = new google.maps.places.Autocomplete(
        //         document.getElementById('searchadd'),
        //         { types: ['geocode'] }
        //     );
        //
        //     autocomplete.addListener('place_changed', function () {
        //         var place = autocomplete.getPlace();
        //         if (!place.geometry) {
        //             alert("No details available for input: '" + place.name + "'");
        //             return;
        //         }
        //
        //         map.setCenter(place.geometry.location);
        //         map.setZoom(17);
        //
        //
        //     });
        // }

        // Fetch and render stations
        function fetchPrices(searchadd = '') {
            $.ajax({
                type: "POST",
                url: "{{ route('fuel_prices.results') }}",
                data: { searchadd: searchadd, _token: '{{ csrf_token() }}' },
                success: function (response) {
                    // console.log(response.stations);
                    if (response.stations.length > 0) {
                        renderPrices(response.stations);
                    } else {
                        $('#showresults').html('<p style="text-align:center;margin-top:200px;color:red;font-weight:900">' + localizedStrings.noDataFound + '</p>');
                        if (map) {
                            map.setCenter({ lat: 0, lng: 0 });
                        }
                    }
                },
                error: function () {
                    alert(localizedStrings.loadingMapError);
                }
            });
        }

        // Render stations in the sidebar and set markers
        function renderPrices(stations) {
            var html = '';
            markersOnMap = []; // Reset markers

            stations.forEach(function(station) {
                var geolocation = station.geolocation ? station.geolocation.split(',') : [0, 0];
                var lat = parseFloat(geolocation[0]);
                var lng = parseFloat(geolocation[1]);

                // Add to markersOnMap array
                markersOnMap.push({
                    placeName: `<div id='markerDiv${station.id}'><div class='pumpbefore6am'>${station.before6amprice}</div><div class='pumpafter6am'>${station.after6amprice}</div><div class='pumpname'>${station.station_name}</div></div>`,
                    LatLng: { lat: lat, lng: lng },
                    idofmap: station.id
                });

                // Sidebar content
                html += makePriceItem(station);
            });
            // Inject HTML
            $('#showresults').html(html);

            // Now that the map container (#map) is in the DOM, initialize the map
            initMap();

            // Attach event listeners
            attachEventListeners();
        }

        function makePriceItem(station) {
            return `
                     <li class="nav-item${station.id}">
                        <a class="nav-link active show sidebara sidebar${station.id}" data-toggle="tab" href="#tab-${station.id}">
                            <div class="station-item-container" style="display: flex; justify-content: space-between; align-items: center;">

                                <!-- Left Section: Prices -->
                                <div class="station-prices" style="text-align: left;">
                                    <div class="price-today">
                                        <h4 style="color: #e63946; font-size: 20px; margin-bottom: 5px;">
                                            ${station.before6amprice ? station.before6amprice : 'N/A'}
                                        </h4>
                                        <small style="font-size: 12px; font-weight: bold;">${localizedStrings.today}</small>
                                    </div>
                                    <div class="price-tomorrow">
                                        <h4 style="font-size: 16px; margin-bottom: 5px;">
                                            ${station.after6amprice ? station.after6amprice : 'N/A'}
                                        </h4>
                                        <small style="font-size: 12px;">${localizedStrings.tomorrow}</small>
                                    </div>
                                </div>

                                <!-- Center Section: Station Info -->
                                <div class="station-info" style="text-align: center; flex-grow: 1;">
                                    <p style="font-size: 18px; font-weight: bold;">
                                        ${station.station_name}
                                    </p>
                                    <p style="font-size: 12px; margin-top: 5px;">
                                        ${station.street_address}
                                    </p>
                                </div>

                                <!-- Right Section: Station Logo -->
                                <div class="station-logo" style="margin-left: 10px;">
                                    <img src="/assets/img/fuel-logo.png" alt="${station.station_name} Logo" style="height: 50px; width: auto;" />
                                </div>
                            </div>
                        </a>
                    </li>


                    <div class="sidebarcontents sidebarcontent${station.id}" style="padding:15px; border:none; background: transparent; display:none">
                        <div class="row">
                            <div class="col-sm-4" style="margin-top:15px;margin-bottom:15px">
                                <button class="btn btn-primary backbtn" style="font-size: 11px;line-height: 0.5;border:1px solid lightgrey">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> ${localizedStrings.back }
                                </button>
                            </div>
                            <div class="col-sm-8" style="margin-top:15px;margin-bottom:15px">
                                <p>${station.station_name}</p>
                            </div>
                            <div class="col-sm-12" style="border-top:1px solid lightgrey;border-bottom:1px solid lightgrey">
                                <p style="margin-bottom: 0px;padding-top: 10px;padding-bottom:10px">
                                    <i class="fa fa-location-arrow"></i> ${station.street_address}
                                </p>
                            </div>
                            <div class="col-sm-12" style="border-top:1px solid lightgrey;border-bottom:1px solid lightgrey">
                                <p style="margin-bottom: 0px;padding-top: 10px;padding-bottom:10px">
                                    <i class="fa fa-phone" aria-hidden="true"></i> ${station.phone_no}
                                </p>
                            </div>
                        </div>

                       <div class="row" style="margin-top:15px;margin-bottom:15px;">
                          <div class="col-sm-12" style=""><h4 style="margin-bottom: 0px;font-family: sans-serif;font-size: 18px;font-weight: 700;padding-bottom:20px">${localizedStrings.ulpPrices}</h4>

                          </div>
                          <div class="col-sm-6" style="text-align: center;"><h4 style="    margin-bottom: 0px;    font-family: sans-serif;">${station.before6amprice}</h4>
                            <small>${localizedStrings.today}</small>
                           </div>


                          <div class="col-sm-6" style="text-align: center;"><h4 style="    margin-bottom: 0px;    font-family: sans-serif;">${station.after6amprice}</h4>
                            <small>${localizedStrings.tomorrow}</small>
                          </div>

                        </div>
                        <div class="row" style="padding-top:30px;padding-bottom:30px;border-top:1px solid lightgrey;border-bottom:1px solid lightgrey;">
                            <div class="col-sm-12">
                                <a class='btn btn-danger' style="background: rebeccapurple;width: 100%;" target="_blank" href='https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(station.geolocation)}'>
                                    ${localizedStrings.getDirections}
                                </a>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <a class='btn btn-danger' style="background: #299ef4;width: 100%;" href='#'>
                                    ${localizedStrings.updatePrices}
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
                var id = $(this).attr('class').match(/sidebar(\d+)/)[1];

                // Hide all .nav-item elements (sidebar list items)
                // $('.nav-item').hide();

                $(".sidebara").hide();

                // Hide all .sidebarcontents elements (detailed content)
                $('.sidebarcontents').hide();

                // Show the specific sidebarcontent for the clicked station
                $('.sidebarcontent' + id).show();

                // here I need to add border as actual selected into marker item on map
                // Add a border to the corresponding marker on the map
                highlightMarker(id);
            });

            // Handle back button clicks using delegation
            $(document).on('click', '.backbtn', function() {
                // Hide all .sidebarcontents elements
                $('.sidebarcontents').hide();

                // $(".sidebara").show();
                // Remove the highlighted border from the selected marker
                if (selectedMarker) {
                    resetMarkerStyle(selectedMarker);
                    selectedMarker = null; // Reset the selected marker
                }

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

                // Add a border to the corresponding marker on the map
                highlightMarker(id);
            });
        }


        // Function to add a highlight (border) to the selected marker
        function highlightMarker(id) {
            if (selectedMarker) {
                resetMarkerStyle(selectedMarker); // Reset the previously selected marker
            }

            // Find the marker corresponding to the stationId
            let marker = markersOnMap.find(function(markerData) {
                return markerData.idofmap == id;
            });

            // console.log(marker)

            if (marker) {
                // Highlight the sidebar element for the marker
                var markerDiv = document.getElementById('markerDiv' + id);
                if (markerDiv) {
                    markerDiv.style.border = "2px solid red";  // Set border to highlight
                }

                selectedMarker = marker; // Store the selected marker
            }
        }

        // Function to reset the marker style to its default
        function resetMarkerStyle(markerData) {
            if (markerData) {
                // Reset the border of the corresponding markerDiv
                var markerDiv = document.getElementById('markerDiv' + markerData.idofmap);
                if (markerDiv) {
                    markerDiv.style.border = "none";  // Remove border to reset
                }
            }
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
            alert(localizedStrings.loadingMapError);
        }
    </script>
@endpush
