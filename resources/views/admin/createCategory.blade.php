@extends('layouts.app')

<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();

?>
@section('content')


    <div class="container-fluid p-5 jumbotron jumbotron-fluid bg-transparent">
        <div class="container justify-content-center pb-2 pr-5">
            <h1 class="text-white font-weight-bolder">Create new category</h1></br>
        </div>
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
        <div class=" justify-content-center card text-white grey-box-card p-5">
            <form action="{{route('store_category')}}" method="POST" >
                    <label for='name'>Name:</label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                        </div>
                        <input type="text" name="name" value="{{ old('name', $category->name ?? '')}}" class="form-control" >
                    </div>
                    <div class="text-danger pb-3">{{ $errors->first('name') }}</div>


                    <button type="submit" class="btn btn-lg btn-blue my-2 ml-4 px-5">Add category</button>



            @csrf

            </form>
        </div>
        <div class=" justify-content-center card text-white grey-box-card p-5">
            <h2>Existing categories</h2>
            <ul class="row">
                @foreach($categories as $category)
                    <li class=" col-lg-3 my-2">
                        <div class="row">
                            <div class="col-6">{{$category->name}}</div>
                            <div class="col-6"><a href="/deleteCategory/{{$category->id}}"><div class="btn btn-danger">Delete</div></a></div>
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>

@endsection
