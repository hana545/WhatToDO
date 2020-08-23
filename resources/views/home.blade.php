@extends('layouts.app')

@section('content')
    <div class=" jumbotron-fluid bg-transparent" style="overflow: hidden">
        <div class="mt-5 container text-center">
            <h1  style="color: whitesmoke">Are you bored?</h1>
            <p class="lead" style="font-weight: revert; color: #9ebcdb">Search interesting places around you</p>
            <img class="img-fluid" src="images/illustrations/locations.svg" style="height: 180px; width: 410px;">
            <hr>
        </div>

        <div class="mt-4 bg-transparent">
            <div class="container">
                <div class="row ">
                    <div class="col-md-6">
                        <div class="card mb-4 box-shadow zoom ">
                            <img class="card-img m-3 " style="height: 225px; " src="images/illustrations/map.svg">
                            <div class="card-body">
                                <p class="card-text text-center" >
                                    <b>Search places around you</b>
                                </p>
                                <div class="align-items-center">
                                    <p class="text-center">
                                        <a href="{{route('search')}}"><button type="button"  class="btn btn-bluedark btn-lg zoom"><b>Search <i class="fa fa-search" aria-hidden="true"></i></b></button></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4 box-shadow zoom">
                            <img class="card-img-top m-3" style="height: 225px;" src="images/illustrations/category.svg">
                            <div class="card-body">
                                <p class="card-text text-center">
                                    @guest<b>Login to add interesting places</b> @endguest
                                    @auth <b>Add interesting places</b> @endauth
                                </p>
                                <div class="align-items-center">
                                    <p class="text-center">
                                        <a @guest href="{{ route('login') }}" @endguest @auth  href="{{ route('add_object') }}" @endauth><button type="button" style="background-color: #0f6674;" class="btn btn-bluedark btn-lg zoom"><b>@auth Add @endauth @guest Login @endguest <i class="fa fa-search"></i></button></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
