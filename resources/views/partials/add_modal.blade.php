<div class="modal fade" id="fuelPriceModal" tabindex="-1" role="dialog" aria-labelledby="fuelPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="fuelPriceModalLabel">Add Fuel Price</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="aria-hidden">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="addFuelPrice" class="form-horizontal form-label-left">
                <div class="modal-body">
                    @csrf
                    <!-- Hidden fields to store latitude and longitude -->
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="purchase_date">Purchase Date</label>
                            <input type="date" class="form-control" name="purchase_date" id="purchase_date" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                            <small id="purchase_dateError" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="purchase_time">Purchase Time</label>
                            <input type="time" class="form-control" name="purchase_time" id="purchase_time"  value="{{ now()->format('H:i') }}">
                            <small id="purchase_timeError" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="litres">Litres</label>
                            <input type="number" step="0.01" class="form-control" name="litres" id="litres">
                            <small id="litresError" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price">Amount</label>
                            <input type="number" step="0.01" class="form-control" name="price" id="price">
                            <small id="priceError" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fuel_type">Fuel Type</label>
                        <input type="text" class="form-control" name="fuel_type" id="fuel_type">
                        <small id="fuel_typeError" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="phone_no">Phone Number</label>
                        <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="+810000000000">
                        <small id="phone_noError" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="station_id">Select Station</label>
                        <select class="form-control" id="station_id" name="station_id" style="width: 100%;">
                            <!-- Options will be loaded via AJAX -->
                        </select>
                        <small id="station_idError" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                        <small id="commentError" class="form-text text-danger"></small>
                    </div>
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" name="photo" id="photo">
                        <label class="custom-file-label" for="photo">Upload Photo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="fuelPrice" name="form_type">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('purchase_date');
            const timeInput = document.getElementById('purchase_time');

            function updateTimeMax() {
                const selectedDateValue = dateInput.value;
                if (!selectedDateValue) {
                    // If no date is selected, remove max attribute
                    timeInput.removeAttribute('max');
                    return;
                }

                const selectedDate = new Date(selectedDateValue);
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Set time to midnight

                if (selectedDate.toDateString() === today.toDateString()) {
                    // If selected date is today, set max time to current time
                    const now = new Date();
                    const hours = now.getHours().toString().padStart(2, '0');
                    const minutes = now.getMinutes().toString().padStart(2, '0');
                    timeInput.max = `${hours}:${minutes}`;
                } else {
                    // If selected date is in the past or future, remove max attribute
                    timeInput.removeAttribute('max');
                }
            }

            // Initialize on page load
            updateTimeMax();

            // Listen for changes on the date input
            dateInput.addEventListener('change', updateTimeMax);

            // Check if the Geolocation API is supported by the browser
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        // Success callback: store latitude and longitude in hidden fields
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                    },
                    function (error) {
                        // Error callback: handle errors if user denies or there are issues
                        console.error("Error getting geolocation: ", error.message);
                    }
                );
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        });

        $(document).ready(function() {
            // Initialize Select2 on the station select element
            $('#station_id').select2({
                tags: true,
                placeholder: 'Choose station...',
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
                // Optional: Set initial value if editing a record
                // templateResult: formatStation,
                // templateSelection: formatStationSelection,
            });
        });

        // Optional: Format the station result if you need to display more information
        function formatStation(station) {
            if (station.loading) {
                return station.text;
            }

            var $container = $(
                "<div class='select2-result-station clearfix'>" +
                "<div class='select2-result-station__title'></div>" +
                "</div>"
            );

            $container.find(".select2-result-station__title").text(station.text);

            return $container;
        }

        // Optional: Format the selected station
        function formatStationSelection(station) {
            return station.text || station.id;
        }
    </script>
@endpush
