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

        <div class=" justify-content-center card text-dark grey-box-card p-5">
            @foreach($places as $place)
                <div class="card">
                  {{$place->name}}
                    <a href="/approve/{{$place->id}}"><div class="btn btn-blue-org">Approve</div></a>
                    <div class="border">{{$place->approved}}</div>
                </div>
            @endforeach
        </div>

@endsection
