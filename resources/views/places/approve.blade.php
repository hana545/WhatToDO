@extends('layouts.app')

<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();

?>
@section('content')


    <div class="container-fluid p-5 jumbotron jumbotron-fluid bg-transparent">
        <div class="container justify-content-center pb-2 pr-5">
            <h1 class="text-white font-weight-bolder">Approve added places</h1></br>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success timeout" role="alert" style="border-width: 1px; border-color: #27864f">
                <strong>Success</strong> {{ session()->get('message') }}
            </div>
        @endif

        @if(!$places->isEmpty())
            <div class="row pl-4">
                @foreach($places as $place)
                    <div class="my-3">
                        <div class="card zoom ">
                            <div class="card-body">
                                <div class="text-center row">
                                    <h4 class="col-md-8 card-title p-2">{{ $place->name }}</h4>
                                </div>
                                <h6 class="card-subtitle text-muted row">
                                    <p class="col-sm">    <i class="fas fa-map-marker-alt"></i> {{ $place->address }}</p>
                                </h6>
                                <h6 class="card-text text-muted row">
                                    <p class="col-sm-5"> <i class="fas fa-tag"></i>   {{ $place->category->name }}</p>
                                <h6 class="card-text text-muted row">
                                    <p class="col-sm"> <i class="fas fa-address-card"> </i> {{$place->user->email}}</p>
                                </h6>

                                <form action="approve/place/delete/{{$place->id}}" method="post" class="">
                                    <button type="button" class="btn btn-lightblue  btn-md my-2 ml-4 center-block" data-toggle="modal" data-target="#modal{{$place->id}}">Details</button>
                                    <a href="approve/{{$place->id}}"><div class="btn btn-blue">Approve</div></a>
                                    <button class="btn btn-danger" type="submit" ><i class="fa fa-trash"></i></button>
                                    @method('delete')
                                    @csrf
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class=" mt-5 rounded-pill">
                <div class=" text-center">
                    <h4 class="mx-auto text-white font-weight-bolder">No new objects to approve </h4>

                </div>
            </div>
        @endif
        @foreach($places as $place)
            @include('places.details_approve',  ['place' => $place])
        @endforeach
    </div>




@endsection
