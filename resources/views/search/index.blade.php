@extends('layouts.app')

@section('content')
    <div class="jumbotron bg-transparent">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="text-white p-3 row">
            <div class="col-md-6">
                <h2>What do you want to search?</h2>
            </div>
            <div class="col-md-6 pull-right">
               Radio buttons za mapu ili listu
            </div>
        </div>
        <div class="row justify-content-center">

            <a class="col-md zoom text-dark" href="{{route('search')}}" style="text-decoration: none">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-sm-3">
                            <img src="images/illustrations/map.svg" class="card-img" >
                        </div>
                        <div class="col-sm-9">
                            <div class="card-body">
                                <h5 class="card-title">All places around you</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a class="col-md zoom text-dark" href="{{route('search')}}" style="text-decoration: none">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-sm-3">
                            <img src="images/illustrations/map.svg" class="card-img" >
                        </div>
                        <div class="col-sm-9">
                            <div class="card-body">
                                <h5 class="card-title">Search by category</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a class="col-md zoom text-dark" href="{{route('search')}}" style="text-decoration: none">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-sm-3">
                            <img src="images/illustrations/map.svg" class="card-img" >
                        </div>
                        <div class="col-sm-9">
                            <div class="card-body">
                                <h5 class="card-title">Search by tags</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
            <div class="container-fluid justify-content-center p-5 m-5">    Ovdje prikazati mapu?</div>


    </div>
@endsection
