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
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="purchase_date">Purchase Date</label>
                            <input type="date" class="form-control" name="purchase_date" id="purchase_date">
                            <small id="purchase_dateError" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="purchase_time">Purchase Time</label>
                            <input type="time" class="form-control" name="purchase_time" id="purchase_time">
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
                    @if($stations->count() > 0)
                        <div class="form-group">
                            <label for="station_id">Select Station</label>
                            <select class="form-control" id="station_id" name="station_id">
                                <option value="">Select Station</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->station_id }}">{{ $station->station_name }}</option>
                                @endforeach
                            </select>
                            <small id="station_idError" class="form-text text-danger"></small>
                        </div>
                    @endif
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
