@extends('layouts.app')

@section('content')
    <div class=" bg-transparent">
        <div class="m-5 text-white p-3 row">
            <div class="col-md">
                <h2>What do you want to search?</h2>


            </div>
            <div class="col-md">
                <!-- Search form -->

                <form class="container"  action="{{route('search_objects')}}" method="POST">
                    <input class="form-control form-control-sm my-3" type="text" name="search_name" placeholder="Search places"
                           aria-label="Search">
                    <div class="row my-3">
                        <div class="col-lg-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active btn-outline-bluedark-org border-bottom" id="v-pills-location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">Location</a>
                                <a class="nav-link  btn-outline-bluedark-org border-bottom" id="v-pills-categories-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="categories" aria-selected="false">Categories</a>
                                <a class="nav-link  btn-outline-bluedark-org" id="v-pills-tags-tab" data-toggle="tab" href="#tags" role="tab" aria-controls="tags" aria-selected="false">Tags</a>
                            </div>
                        </div>

                        <div class="col-lg-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="location-tab">@include('search.location')</div>
                                <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">@include('search.categories', ['categories' => $categories])</div>
                                <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags-tab">@include('search.tags', ['tags' => $tags])</div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-outline-bluelight-org btn-secondary" value="Search">
                    <a href="{{route('search')}}"> <button  class="btn btn-outline-bluelight-org btn-secondary" >Cancel filters</button></a>
                @csrf
                </form>

            </div>

        </div>

        <div class="container-fluid justify-content-center">
            <div class="row">
                <div class="col-md-3 overflow-auto border-left " style="height: 600px">
                    <a href="#map"><button class="btn btn-blue-org"  v-on:click="showMe()" id="locate">Show my location!</button></a>
                    @if(!$find)
                        <div class="card  ">
                            <div class="card-body">
                                There are no matching objects
                            </div>
                        </div>
                    @endif
                    @foreach($places as $place)
                        <div class="my-3">
                            <div class="card zoom ">
                                <div class="card-body">
                                    <h4 class="card-title p-2">{{ $place->name }}</h4>
                                    <h6 class="card-subtitle text-muted row">
                                        <i class="fas fa-map-marker-alt col-sm-1"></i>
                                        <p class="col-sm"> {{ $place->address }}</p>
                                    </h6>
                                    <h6 class="card-text text-muted row">
                                        <p class="col-sm-5"> {{ $place->category->name }}</p>
                                        <p class="col-sm-7"><i class="fas fa-route mx-2 col-sm-1"></i>~{{ number_format($place->dist, 2, '.', '') }}km</p></h6>
                                    <h6 class="card-text text-muted row">
                                        <p class="col-sm-5 border-right"> {{ $place->phones->first()->number }}</p>
                                        <p class="col-sm-7"> {{ $place->emails->first()->email }}</p>
                                    </h6>
                                    <button type="button" class="btn btn-blue-org btn-lg my-2 ml-4 center-block" data-toggle="modal" data-target="#modal{{$place->id}}">Details</button>
                                    <a href="#map"><button  class="btn btn-secondary"  v-on:click="showPlace({{$place->lat}},{{$place->lng}})">Show on map</button></a>


                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-9">
                    <div id="map" v-if="gettingLocation" style="height: 600px">
                        <l-map :center="center" :zoom="zoom" ref="mymap">
                            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                            <l-marker :lat-lng="myLocation" :icon="redIcon"><l-tooltip :content="myLocationstring"></l-tooltip></l-marker>
                            @foreach($places as $place)
                                <l-marker :lat-lng="{'lat': {{$place->lat}}, 'lng': {{$place->lng}}}"><l-tooltip :content="'{{$place->name}}'"></l-tooltip></l-marker>
                            @endforeach
                        </l-map>
                    </div>
                </div>


                <div>
                    @foreach($places as $place)
                        @include('search.details',  ['place' => $place])
                    @endforeach
                </div>

            </div>

        </div>
    </div>
@endsection
