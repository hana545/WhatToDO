@extends('layouts.app')

@section('content')
    <div class=" bg-transparent">
        <div class="m-5 mb-2     text-white p-3 row">
            <div class="col-md-4">
                <h2>What do you want to search?</h2>

                @if(session()->has('message'))
                    <div class="alert alert-success" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Success</strong> {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Error</strong> {{ session()->get('error') }}
                    </div>
                @endif
                @if($errors->first('text_review'))
                    <div class="alert alert-danger" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Error</strong> {{ $errors->first('text_review') }}
                    </div>
                @endif

            </div>
            <div class="col-md-8">
                <!-- Search form -->
                <div class="container" >
                    <form  action="{{route('search_objects')}}" method="POST">
                        <input class="form-control form-control-sm my-3" type="text" name="search_name" placeholder="Search places"
                               aria-label="Search">
                        <div class="row my-3">
                            <div class="col-lg-2">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active btn-outline-bluedark border-bottom" id="v-pills-location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">Location</a>
                                    <a class="nav-link  btn-outline-bluedark border-bottom" id="v-pills-categories-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="categories" aria-selected="false">Categories</a>
                                    <a class="nav-link  btn-outline-bluedark" id="v-pills-tags-tab" data-toggle="tab" href="#tags" role="tab" aria-controls="tags" aria-selected="false">Tags</a>
                                </div>
                            </div>

                            <div class="col-lg-10">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="location-tab">@include('search.location')</div>
                                    <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">@include('search.categories', ['categories' => $categories, 'categories_req' => $categories_req ])</div>
                                    <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags-tab">@include('search.tags', ['tags' => $tags])</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-2">
                            <input type="checkbox" value="1" name="random" @if($random) checked @endif>Pick one random place so you dont have to choose
                        </div>
                        <input type="submit" class="btn btn-blue text-center" value="Search" style="width: 115px">
                        @csrf
                    </form>

                    <a href="{{route('search')}}"> <button  class="btn btn-dark  text-center" style="width: 115px">Cancel filters</button ></a>
                    <a href="#map" class=""><button class="btn btn-blue m-2"  v-on:click="showMe()" id="locate">Show my location!</button></a>
                </div>
            </div>
        </div>
        <div class="container-fluid justify-content-center m-1 mb-0 ">

            <div class="row">
                <div class="col-md-3 overflow-auto border-left " style="height: 600px">
                    @if(!$find)
                        <div class="card  ">
                            <div class="card-body">
                                There are no matching objects
                                @if(!empty($categories_req) || !empty($tags_req) || !empty($search_name))
                                    with
                                    <label class="btn btn-blue-check col-auto px-2 m-1">
                                        Search:{{ $search_name}}
                                    </label>

                                @endif
                                @if(!empty($categories_req))
                                    @foreach ($categories as $category)
                                        @foreach($categories_req as $checked)
                                            @if($category->id == $checked)
                                                <label class="btn btn-blue-check col-auto px-2 m-1">
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
                                                <label class="btn btn-blue-check col-auto px-2 m-1">
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
                            <div class="my-3">
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
                                            <i class="fas fa-map-marker-alt col-sm-1"></i>
                                            <p class="col-sm"> {{ $place->address }}</p>
                                        </h6>
                                        <h6 class="card-text text-muted row">
                                            <p class="col-sm-5"> {{ $place->category->name }}</p>
                                            <p class="col-sm-7"><i class="fas fa-route mx-2 col-sm-1"></i>~{{ number_format($place->dist, 2, '.', '') }}km</p></h6>
                                        <h6 class="card-text text-muted row">
                                            <p class="col-sm-5 border-right"> </p>
                                            <p class="col-sm-7"></p>
                                        </h6>
                                        <button type="button" class="btn btn-blue  btn-md my-2 ml-4 center-block" data-toggle="modal" data-target="#modal{{$place->id}}">Details</button>
                                        <a href="#map"><button  class="btn btn-dark btn-sm"  v-on:click="showPlace({{$place->lat}},{{$place->lng}})">Show on map</button></a>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                            <div class="my-3">
                                <div class="card zoom ">
                                    <div class="card-body">
                                        <h4 class="card-title p-2">{{ $randomPlace->name }} </h4>
                                        <h6 class="card-subtitle text-muted row">
                                            <i class="fas fa-map-marker-alt col-sm-1"></i>
                                            <p class="col-sm"> {{ $randomPlace->address }}</p>
                                        </h6>
                                        <h6 class="card-text text-muted row">
                                            <p class="col-sm-5"> {{ $randomPlace->category->name }}</p>
                                            <p class="col-sm-7" ><i class="fas fa-route mx-2 col-sm-1"></i>~{{ number_format($randomPlace->dist, 2, '.', '') }}km</p></h6>

                                        <button type="button" class="btn btn-blue  btn-md my-2 ml-4 center-block" data-toggle="modal" data-target="#modal{{$randomPlace->id}}">Details</button>
                                        <a href="#map"><button  class="btn btn-sm btn-dark"  v-on:click="showPlace({{$randomPlace->lat}},{{$randomPlace->lng}})">Show on map</button></a>


                                    </div>
                                </div>
                            </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div id="map" v-if="gettingLocation" style="height: 600px">
                        <l-map :center="center" :zoom="zoom" :no-blocking-animations="true" ref="mymap">
                            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                            <l-marker :lat-lng="myLocation" :icon="redIcon"><l-tooltip :content="myLocationstring"></l-tooltip></l-marker>
                            @if($randomPlace)
                                <l-marker :lat-lng="{'lat': {{$randomPlace->lat}}, 'lng': {{$randomPlace->lng}}}" :icon="greenIcon"><l-tooltip :content="'{{$randomPlace->name}}'"></l-tooltip></l-marker>
                            @else
                                @foreach($places as $place)
                                    <l-marker :lat-lng="{'lat': {{$place->lat}}, 'lng': {{$place->lng}}}"><l-tooltip :content="'{{$place->name}}'"></l-tooltip></l-marker>
                                @endforeach
                            @endif
                        </l-map>
                    </div>
                </div>


                <div>
                    @foreach($places as $place)
                        @include('search.details',  ['place' => $place])
                        @include('search.review',  ['place' => $place])
                    @endforeach
                </div>

            </div>

        </div>
    </div>
@endsection
