<div class="my-2">
    <div class="btn-group-toggle  row justify-content-around" data-toggle="buttons">
        <label class="btn btn-blue-check col-auto px-4">
            <input type="radio" checked name="location"
                   value="1">
            Around me
        </label>
        <label class="btn btn-blue-check col-auto px-4">
            <input type="radio" name="location"
                   value="0">
            Around my saved locations
        </label>
    </div>
    <div class="collape" id="distance">
        <div class="col-12 mt-3">
            <input type="range" class="custom-range" min="0" max="150" step="1" id="rangeIndicator" value="{{ $range }}">
            <input type="hidden" id="inputRangeValue" name="range" value="{{ $range }}">
            <span>Range Value: <span id="rangeValue"></span>km
        </div>
    </div>
</div>



