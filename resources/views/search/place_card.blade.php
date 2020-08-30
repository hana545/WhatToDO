
<div class="my-3" v-bind:class="{ 'col-md' : !showMap}">
    <div class="card zoom ">
        <div class="card-body">
            <div class='text-center row'>
                <h4 class="col-md-8 card-title p-2">{{ $place->name }}</h4>
               <ul class="col-md-4 btn btn-outline-secondary stars-button"  data-toggle="modal" data-target="#modalreview{{$place->id}}">
                   @include('reviews.star_small_rating', ['star' => $place->avgStar ?? 0])
               </ul>
            </div>

            <h6 class="card-subtitle text-muted row">
                <p class="col-sm">    <i class="fas fa-map-marker-alt"></i> {{ $place->address }}</p>
            </h6>
            <h6 class="card-text text-muted row">
                <p class="col-sm-5"> <i class="fas fa-tag"></i>   {{ $place->category->name }}</p>
                <p class="col-sm-7">@if($place->open == 1)<span class="text-success"><i class="fas fa-door-open"></i> Opened </span> @elseif($place->open == 0) <span class="text-danger"><i class=" fas fa-door-closed"></i> Closed</span> @else <span>No workhours</span></span>  @endif</p></h6>

            <button type="button" class="btn btn-blue  btn-md my-2 ml-4 center-block" data-toggle="modal" data-target="#modal{{$place->id}}">Details</button>
            <a href="#map"><button  class="btn btn-dark btn-sm"  v-on:click="showPlace({{$place->lat}},{{$place->lng}}); ShowMap()">Show on map</button></a>
        </div>
    </div>
</div>

