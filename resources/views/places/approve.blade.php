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
            <div class="alert alert-success" role="alert" style="border-width: 1px; border-color: #27864f">
                <strong>Success</strong> {{ session()->get('message') }}
            </div>
        @endif

        @if(!$places->isEmpty())
            <div class="row pl-4">
                @foreach($places as $place)
                    <div class="col-lg-4 col-sm-8 col-md-8 my-4" >
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title p-2">{{ $place->name }}</h4>
                                <h5 class="card-title p-2">{{ $place->address }}</h5>
                                <p class="card-text">{{ $place->description }}</p>
                                <h6 class="card-subtitle mb-2 text-muted row"><i class="fas fa-list-alt pr-2 col-sm-1"></i><p class="col-sm-11">{{ $place->category->name }}</p></h6>
                                <div class="row">
                                    <div class="col-4   text-center border-right ">
                                        <div class="p-2 mt-2">
                                            <p> <i class="fas fa-th-list"></i> <strong>Phone:</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-8   text-center">
                                        @foreach($place->phones as $phone)
                                            <div class="p-2">
                                                <p>{{ $phone->number}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4   text-center border-right ">
                                        <div class="p-2">
                                            <p> <i class="fas fa-th-list"></i> <strong>Email:</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-8   text-center ">
                                        @foreach($place->emails as $email)
                                            <div class="p-2">
                                                <p>{{ $email->email}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4   text-center border-right ">
                                        <div class="p-2">
                                            <p> <i class="fas fa-th-list"></i> <strong>Websites:</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-8  text-center ">
                                        @foreach($place->website as $website)
                                            <div class="p-2">
                                                <p><a href="{{ $website->url}}">{{ $website->url}}</a></p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <a href="/approve/{{$place->id}}"><div class="btn btn-blue">Approve</div></a>
                                <a href="/deleteObject/{{$place->id}}"><div class="btn btn-danger">Delete</div></a>
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
    </div>




@endsection
