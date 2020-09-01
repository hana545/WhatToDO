<div class="my-2">
    <div class="btn-group-toggle  row justify-content-around" data-toggle="buttons">
        <label   v-on:click="hideLocations()" class="btn btn-blue-check col-auto px-4">
            <input type="radio"  @if(!$mysaveloc) checked @endif name="location"
                   value="1">
            Around me
        </label>
        <label  class="btn btn-blue-check col-auto px-4 @guest disabled @endguest "  @guest title="You need to login to use saved locations"  @endguest>
            <input v-on:click="showLocations()" type="radio"  @if($mysaveloc) checked @endif ref="savedlocation" name="location" @guest disabled @endguest
                   value="2" >
            Around my saved locations
        </label>
        @auth
            <div class="col-8 mx-5 mt-4" v-show="showLoc">
                <select name="savedLocation" class="form-control">
                    <option value="" disabled="" selected>Select a location </option>
                    @foreach($user->locations as $location)
                        @php $latlng = json_encode([$location->name, $location->lat, $location->lng]) @endphp
                        <option value="{{$latlng}}" @if($location->name == $mysavelocname) selected @endif>{{$location->name}}</option>
                    @endforeach
                </select>
            </div>

        @endauth
    </div>
    <input type="text" value="{{$lat}}" ref="mylat" style="display: none">
    <input type="text"  value="{{$lng}}" ref="mylng" style="display: none">
    <br>
    <div class="collape" id="distance">
        <div class="col-12 mt-3">
            <input type="range" class="custom-range" min="0" max="150" step="1" id="rangeIndicator" v-on:input="ChangeRange($event)" value="{{ $range }}">
            <input type="hidden" id="inputRangeValue" name="range" value="{{ $range }}">
            <span>Range Value: <span id="rangeValue">{{$range}}</span>km
        </div>
    </div>
</div>



