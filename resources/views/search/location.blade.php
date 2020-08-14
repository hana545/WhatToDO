<div class="btn-group-toggle mb-2 row justify-content-around" data-toggle="buttons">
    <label class="btn btn-secondary col-auto px-4">
        <input type="checkbox" checked name="location"
               value="1">
        Around me
    </label>
    <label class="btn  btn-secondary  col-auto px-4">
        <input type="checkbox" name="location"
               value="1">
        Around my saved locations
    </label>
    <div class="collape" id="distance">
        <div class="col-12 mt-3">
            <input type="range" class="custom-range" min="0" max="150" step="1" id="rangeIndicator" value="{{ $range }}">
            <input type="hidden" id="inputRangeValue" name="range" value="{{ $range }}">
            <span>Range Value: <span id="rangeValue"></span>km
        </div>
    </div>
</div>


