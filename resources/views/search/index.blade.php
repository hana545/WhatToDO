@extends('layouts.app')

@section('content')
    <div class="bg-transparent" id="search_map">
        <div class="p-3 mt-3 mb-2 text-white row">
            <div class="col-lg-4">
                <h2>What do you want to search?</h2>

                @if(session()->has('message'))
                    <div class="alert alert-success timeout" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Success</strong> {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger timeout" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Error</strong> {{ session()->get('error') }}
                    </div>
                @endif
                @if($errors->first('text_review'))
                    <div class="alert alert-danger timeout" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Error</strong> {{ $errors->first('text_review') }}
                    </div>
                @endif
                @if(!$lat || !$lng) <div class="alert alert-danger"  style="border-width: 1px; border-color: #27864f">
                    <strong>Error</strong> Enable your location for accurate results
                </div>
                @endif
            </div>
            <div class="col-lg-8">
                <!-- Search form -->
                <div class="container" >
                    <form  action="{{route('search_objects')}}" method="POST">
                        <input class="form-control form-control-sm my-3" type="text" name="search_name" placeholder="Search places"
                               aria-label="Search">
                        <div class=" my-3 border-bottom">
                            <ul class="nav nav-pills nav-fill" id="v-pills-tab">

                                <li class="nav-item">
                                    <a class="nav-link  btn-outline-bluedark " id="v-pills-location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">Location</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  btn-outline-bluedark " id="v-pills-categories-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="categories" aria-selected="false">Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  btn-outline-bluedark" id="v-pills-categories-tab" data-toggle="tab" href="#tags" role="tab" aria-controls="tags" aria-selected="false">Tags</a>
                                </li>
                            </ul>


                            <div class="my-3">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">@include('search.location', ['lat' => $lat, 'lng' => $lng])</div>
                                    <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">@include('search.categories', ['categories' => $categories, 'categories_req' => $categories_req ])</div>
                                    <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags-tab">@include('search.tags', ['tags' => $tags])</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-2">
                            <input type="checkbox" class="mr-2" value="1" name="random" @if($random) checked @endif><label for="random">Pick one random place so you dont have to choose. - Gives only one place.</label>
                        </div>
                        <div class="p-2">
                            <input type="checkbox" value="1" class="mr-2" name="rangeEnabled" @auth @if( Auth::user()->type == false) style="display: none" @endif @endauth  @guest style="display: none" @endguest> @auth @if( Auth::user()->type == true) <label for="rangeEnabled"> Dont use range</label> @endif @endauth

                        </div>
                        <input type="submit" class="btn btn-blue text-center" value="Search" style="width: 115px">
                        @csrf
                    </form>

                    <a href="{{route('search')}}"> <button  class="btn btn-dark  text-center" style="width: 115px">Cancel filters</button ></a>
                    </div>
            </div>
        </div>
        <div class="container-fluid justify-content-center m-1 mb-0 ">

            <a href="#map" class=""><button class="btn btn-blue m-2"  v-on:click="showMe()" id="locate">Show my location!</button></a>
             <button class="btn btn-blue m-2"  v-on:click="toggleShowMap()"><span v-if="showMap">Hide map</span><span v-if="!showMap">Show map</span></button>

            <div class="row">
                <div class="overflow-auto" v-bind:class="{ 'col-md-3' : showMap, 'row': !showMap}" @if($places->count() > 3) style="height: 700px" @endif>
                    @if(!$find)
                        <div class="container text-white" >
                            <div class=" text-center" >
                                There are no matching objects
                                <label class=" blue-tag col-auto px-2 m-1">
                                   in range of {{$range}}km
                                </label>
                                @if(!empty($categories_req) || !empty($tags_req) || !empty($search_name))
                                    with
                                @endif
                                @if(!empty($search_name))
                                    <label class=" blue-tag col-auto px-2 m-1">
                                        Search:{{ $search_name}}
                                    </label>
                                @endif
                                @if(!empty($categories_req))
                                    @foreach ($categories as $category)
                                        @foreach($categories_req as $checked)
                                            @if($category->id == $checked)
                                                <label class=" blue-tag col-auto px-2 m-1">
                                                    {{ $category->name}}
                                                </label>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                                @if(!empty($tags_req))
                                    @foreach ($tags as $tag)
                                        @foreach($tags_req as $checked)
                                            @if($tag->id == $checked)
                                                <label class=" blue-tag col-auto px-2 m-1">
                                                    {{ $tag->name}}
                                                </label>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                    @if(!$randomPlace)
                        @foreach($places as $place)
                            <div class="my-3" v-bind:class="{ 'col-md' : !showMap}">
                                <div class="card zoom ">
                                    <div class="card-body">
                                        <div class='rating-stars text-center row'>
                                            <h4 class="col-md-8 card-title p-2">{{ $place->name }}</h4>
                                           <ul id='' class="col-md-4 btn btn-outline-secondary stars-button"  data-toggle="modal" data-target="#modalreview{{$place->id}}">
                                                <li class='star-small @if($place->avgStar >= 1) selected  @endif' title='Awful' data-value='1' >
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star-small @if($place->avgStar >= 2) selected  @endif' title='Bad' data-value='2'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star-small @if($place->avgStar >= 3) selected  @endif' title='Good' data-value='3'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star-small @if($place->avgStar >= 4) selected  @endif' title='Very good' data-value='4'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star-small @if($place->avgStar >= 5) selected  @endif'  title='Excellent!!!' data-value='5'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>

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
                        @endforeach
                    @else
                            <div class="my-3" >
                                <div class="card zoom ">
                                    <div class="card-body">
                                        <div class='rating-stars text-center row'>
                                            <h4 class="col-md-8 card-title p-2">{{ $randomPlace->name }}</h4>
                                            <ul id='' class="col-md-4 btn btn-outline-secondary stars-button"  data-toggle="modal" data-target="#modalreview{{$randomPlace->id}}">
                                                <li class='star-small @if($randomPlace->avgStar >= 1) selected  @endif' title='Awful' data-value='1' >
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star-small @if($randomPlace->avgStar >= 2) selected  @endif' title='Bad' data-value='2'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star-small @if($randomPlace->avgStar >= 3) selected  @endif' title='Good' data-value='3'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star-small @if($randomPlace->avgStar >= 4) selected  @endif' title='Very good' data-value='4'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star-small @if($randomPlace->avgStar >= 5) selected  @endif'  title='Excellent!!!' data-value='5'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>

                                            </ul>
                                        </div>

                                        <h6 class="card-subtitle text-muted row">
                                            <i class="fas fa-map-marker-alt col-sm-1"></i>
                                            <p class="col-sm"> {{ $randomPlace->address }}</p>
                                        </h6>
                                        <h6 class="card-text text-muted row">
                                            <p class="col-sm-5"> {{ $randomPlace->category->name }}</p>
                                            <p class="col-sm-7"><i class="fas fa-route mx-2 col-sm-1"></i>~{{ number_format($randomPlace->dist, 2, '.', '') }}km</p></h6>
                                        <h6 class="card-text text-muted row">
                                            <p class="col-sm-5 border-right"> </p>
                                            <p class="col-sm-7"></p>
                                        </h6>
                                        <button type="button" class="btn btn-blue  btn-md my-2 ml-4 center-block" data-toggle="modal" data-target="#modal{{$randomPlace->id}}">Details</button>
                                        <a href="#map"><button  class="btn btn-dark btn-sm"  v-on:click="showPlace({{$randomPlace->lat}},{{$randomPlace->lng}})">Show on map</button></a>


                                    </div>
                                </div>
                            </div>
                    @endif
                </div>
                <div class="col-md-9" v-if="showMap">
                    <div id="map" v-if="center" style="height: 600px">
                        <l-map :center="center" :zoom="zoom" :no-blocking-animations="true" ref="mymap">
                            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                            <l-marker v-if="gettingLocation" :lat-lng="myLocation" :icon="redIcon"><l-tooltip :content="myLocationstring"></l-tooltip></l-marker>
                            @if($mysaveloc)
                                <l-marker :lat-lng="savedLoc" :icon="greenIcon" ><l-tooltip :content="'{{$mysavelocname}}'"></l-tooltip></l-marker>
                            @endif
                            @if($randomPlace)
                                <l-marker :lat-lng="{'lat': {{$randomPlace->lat}}, 'lng': {{$randomPlace->lng}}}" :icon="greenIcon"><l-tooltip :content="'{{$randomPlace->name}}'"></l-tooltip></l-marker>
                            @else
                                @foreach($places as $place)
                                    <l-marker :lat-lng="{'lat': {{$place->lat}}, 'lng': {{$place->lng}}}"><l-tooltip :content="'{{$place->name}}'"></l-tooltip></l-marker>
                                @endforeach
                            @endif
                            <l-control position="topleft" >
                                <button v-on:click="showMe"  class="btn m-2" style="background: honeydew">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                            </l-control>
                            <l-control position="topright" class="p-2" style="background: honeydew">
                                <h4>Legend</h4>
                                <i class="dot" style="background: red"></i><span> Your location</span><br>
                                <i class="dot" style="background: blue"></i><span>Places</span><br>
                                <i class="dot" style="background: green"></i><span>Saved location</span><br>
                            </l-control>

                        </l-map>


                    </div>
                </div>


                <div>
                    @foreach($places as $place)
                        @include('places.details',  ['place' => $place])
                        @include('places.review',  ['place' => $place])
                    @endforeach
                </div>

            </div>

        </div>
    </div>
@endsection
