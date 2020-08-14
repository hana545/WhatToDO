@extends('layouts.app')

<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();

?>
@section('content')


    <div class="container-fluid p-5 jumbotron jumbotron-fluid bg-transparent">
        <div class="container justify-content-center pb-2 pr-5">
            <h1 class="text-white font-weight-bolder">Create new tag</h1></br>
        </div>
        <div class=" justify-content-center card text-white grey-box-card p-5">
            <form action="{{route('store_tag')}}" method="POST">

                    <label for='name'>Name:</label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                        </div>
                        <input type="text" name="name" value="{{ old('name', $tag->name ?? '')}}" class="form-control" >
                    </div>
                    <div class="text-danger pb-3">{{ $errors->first('name') }}</div>

                    <label class="" for='description'>Description:</label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-light" ><i class="fas fa-align-center"></i></span>
                        </div>
                        <textarea type="text" class="form-control" name="description" rows="3">{{ old('description', $tag->description ?? '')}} </textarea>
                    </div>
                    <div class="text-danger pb-3">{{ $errors->first('description') }}</div>



                <button type="submit" class="btn btn-lg btn-blue-org my-2 ml-4 px-5">Add tag</button>
                @csrf

            </form>
        </div>
        <div class=" justify-content-center card text-white grey-box-card p-5">
            <h2>Existing tags</h2>
            <ul>
                @foreach($tags as $tag)
                    <li>   {{$tag->id}}:{{$tag->name}}</li>
                @endforeach
            </ul>

        </div>
    </div>

@endsection
