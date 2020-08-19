@extends('layouts.app')

@section('content')


    <div class="container">
        <div class=" order-lg-2 justify-content-center my-5 text-light">

            <div class="text-center">

                @if(session()->has('message'))
                    <div class="alert alert-success" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Success</strong> {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Success</strong> {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Success</strong> {{ session()->get('error') }}
                    </div>
                @endif

                <div class="text-danger pb-3">{{ $errors->first('current-password') }}</div>
                <div class="text-danger pb-3">{{ $errors->first('new-password') }}</div>
                <div class="text-danger pb-3">{{ $errors->first('new-password_confirmation') }}</div>
                <div class="text-danger pb-3">{{ $errors->first('username') }}</div>
            </div>
            <ul class="nav nav-pills nav-fill" id="v-pills-tab">

                <li class="nav-item">
                    <a  data-toggle="tab" href="#reviews" class="nav-link p-3 btn-outline-bluedark"><h7><i class="fas fa-star"></i> My reviews</h7></a>
                </li>
                <li class="nav-item">
                    <a  data-toggle="tab" href="#places" class="nav-link p-3 btn-outline-bluedark"><h7><i class="fas fa-map-marked-alt"></i> My places</h7></a>
                </li>
                <li class="nav-item">
                    <a  data-toggle="tab" href="#settings" class="nav-link p-3 btn-outline-bluedark"><h7><i class="fas fa-user-cog"></i> Settings</h7></a>
                </li>
            </ul>
            <hr class="my-1">

            <div class="tab-content py-2">
                <div class="tab-pane active" id="default">
                    <div class="card text-white grey-box-card m-4 p-5">
                        <div class="text-center">
                            Hello {{ Auth::user()->name }}.
                            <p>Here you can edit your reveiws, update you account and so much more...</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane " id="reviews">
                    <div class="card text-white grey-box-card">
                        <div class="card-header text-center">
                            <h2>{{ __('This is a list of all your reveiws') }}</h2>
                        </div>

                        <div class="card-body">
                            <ul class="">
                                @foreach($user->reviews as $review)
                                    <li class="row p-2">
                                        <div class="col-md-3">

                                            {{$review->place->name}}
                                        </div>
                                        <section class='rating-widget col-md-2'>
                                            <div class='rating-stars text-center'>
                                                <ul id='stars' class="col-md-6"  >
                                                    <li class='star-small @if($review->star >= 1) selected  @endif' title='Awful' data-value='1' >
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star-small @if($review->star >= 2) selected  @endif' title='Bad' data-value='2'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star-small @if($review->star >= 3) selected  @endif' title='Good' data-value='3'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star-small @if($review->star >= 4) selected  @endif' title='Very good' data-value='4'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star-small @if($review->star >= 5) selected  @endif'  title='Excellent!!!' data-value='5'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>

                                                </ul>
                                            </div>
                                        </section>
                                        <div class="col-md-5">
                                            {{$review->description}}
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#"><div class="btn btn-blue">Edit</div></a>
                                            <a href="#"><div class="btn btn-danger">Delete</div></a>
                                        </div>
                                    </li>
                                    <hr class="light-muted-100">
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Here is places tab -->
                <div class="tab-pane" id="places">
                    <div class="card text-white grey-box-card">
                        <div class="card-header text-center">
                            <h2>{{ __('This is a list of all your added places') }}</h2>
                        </div>

                        <div class="card-body">
                            <ul>
                                @foreach($user->places as $place)
                                    <li class="row p-2">
                                        <div class="col-md-3">

                                            {{$place->name}}
                                        </div>
                                        <div class="col-md-5">
                                            {{$place->description}}
                                        </div>
                                        <div class="col-md-2">
                                            {{$place->approved}}
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#"><div class="btn btn-blue">Edit</div></a>
                                            <a href="#"><div class="btn btn-danger">Delete</div></a>
                                        </div>
                                    </li>
                                    <hr class="light-muted-100">
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Here is settings tab -->
                <div class="tab-pane" id="settings">

                    <div class="card text-white grey-box-card">
                        <div class="card-header text-center">
                            <h2>{{ __('Update your account') }}</h2>
                            <h6><b>Joined</b></h6>
                            {{ $user->created_at->format('d.m.Y') }}
                        </div>

                        <div class="card-body">
                            <form id="form-change-password" role="form" method="POST" action="{{  route('change_username') }}" novalidate class="form-horizontal">

                            @csrf
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control text-muted" name="email" value="{{ old('email', $user->email ?? '') }}" disabled autocomplete="email">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control   @error('username') border-danger  @enderror" name="username" value="{{ old('username', $user->name ?? '')}}" required autocomplete="username">

                                        <div class="text-danger pb-3">{{ $errors->first('username') }}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-blue">
                                            Change Username
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <form id="form-change-password" role="form" method="POST" action="{{ route('change_password') }}" novalidate class="form-horizontal">

                                @csrf
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }} row">

                                    <label for="new-password" class="col-md-4 col-form-label text-md-right">Current Password</label>

                                    <div class="col-md-6">
                                        <input id="current-password" type="password" class="form-control  @error('current-password') border-danger  @enderror" name="current-password" required>
                                        <div class="text-danger pb-3">{{ $errors->first('current-password') }}</div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }} row">

                                    <label for="new-password" class="col-md-4 col-form-label text-md-right">New Password</label>

                                    <div class="col-md-6">
                                        <input id="new-password" type="password" class="form-control  @error('new-password') border-danger  @enderror " name="new-password" required>
                                        <div class="text-danger pb-3">{{ $errors->first('new-password') }}</div>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('new-password_confirmation') ? ' has-error' : '' }} row">

                                    <label for="new-password-confirm" class="col-md-4 col-form-label text-md-right"> Confirm New Password</label>

                                    <div class="col-md-6">
                                        <input id="new-password-confirm" type="password" class="form-control  @error('new-password_confirmation') border-danger  @enderror" name="new-password_confirmation" required>
                                        <div class="text-danger pb-3">{{ $errors->first('new-password_confirmation') }}</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-blue">
                                            Change Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
