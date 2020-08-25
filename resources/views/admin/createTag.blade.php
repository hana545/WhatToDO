@extends('layouts.app')

<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();

?>
@section('content')


    <div class="container-fluid pt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-white grey-box-card pt-3 px-2">
                    <div class="card-header text-center">
                        <h2>Create a new tag</br></h2>
                    </div>
                    @if(session()->has('message'))
                        <div class="alert alert-success" role="alert" style="border-width: 1px; border-color: #27864f">
                            <strong>Success</strong> {{ session()->get('message') }}
                        </div>
                    @endif

                    <form action="{{route('store_tag')}}" method="POST">

                            <label for='name'>Name:</label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $tag->name ?? '')}}" class="form-control" >
                            </div>
                            <div class="text-danger pb-3">{{ $errors->first('name') }}</div>


                        <button type="submit" class="btn btn-lg btn-blue my-2 ml-4 px-5">Add tag</button>
                        @csrf

                    </form>
                </div>
                <div class="card text-white grey-box-card pt-3 px-2">
                    <h2>Existing tags</h2>
                    <ul class="row">
                        @foreach($tags as $tag)
                            <div class=" col-sm-3 my-2">
                                <div class="row">
                                    <div class="col">{{$tag->name}}</div>
                                    <form action="/tag/delete/{{$tag->id}}" method="post" class="col">
                                        <input class="btn btn-sm btn-danger" type="submit" value="Delete" />
                                        @method('delete')
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
