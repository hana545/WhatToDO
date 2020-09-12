@extends('layouts.app')

@section('content')


    <div class="container">
        <div class=" order-lg-2 justify-content-center mt-5 text-light">

            <div class="text-center">

                @if(session()->has('message'))
                    <div class="alert alert-success timeout" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Success</strong> {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success timeout" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Success</strong> {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger timeout" role="alert" style="border-width: 1px; border-color: #27864f">
                        <strong>Error</strong> {{ session()->get('error') }}
                    </div>
                @endif

                <div class="text-danger pb-3">{{ $errors->first('current-password') }}</div>
                <div class="text-danger pb-3">{{ $errors->first('new-password') }}</div>
                <div class="text-danger pb-3">{{ $errors->first('new-password_confirmation') }}</div>
                <div class="text-danger pb-3">{{ $errors->first('username') }}</div>
                <div class="text-danger pb-3">{{ $errors->first('name') }}</div>
                <div class="text-danger pb-3">{{ $errors->first('address') }}</div>
            </div>
            <ul class="nav nav-pills nav-fill" id="v-pills-tab">

                <li class="nav-item">
                    <a  data-toggle="tab" href="#reviews" class="nav-link p-3 btn-outline-bluedark"><h6><i class="fas fa-star"></i> My reviews</h6></a>
                </li>
                <li class="nav-item">
                    <a  data-toggle="tab" href="#locations" class="nav-link p-3 btn-outline-bluedark"><h6><i class="fas fa-map-marked-alt"></i> My locations</h6></a>
                </li>
                <li class="nav-item">
                    <a  data-toggle="tab" href="#places" class="nav-link p-3 btn-outline-bluedark"><h6><i class="fas fa-map-marked-alt"></i> My places</h6></a>
                </li>
                <li class="nav-item">
                    <a  data-toggle="tab" href="#settings" class="nav-link p-3 btn-outline-bluedark"><h6><i class="fas fa-user-cog"></i> Settings</h6></a>
                </li>
            </ul>
            <hr class="my-1">

            <div class="tab-content py-2">
                <div class="tab-pane active" id="default">
                    <div class="text-white m-4 p-5">
                        <div class="text-center">
                            <h3> Hello {{ Auth::user()->name }}.</h3>
                            <img class="img-fluid" src="{{asset('images/illustrations/mobile_user.svg')}}" style="height: 180px; width: 410px;">

                            @if(Auth::user()->suspended == true)
                                <h5 class="text-danger">Your account have been suspended. You cant add new places, reviews or save you locations any more</h5>
                            @else
                                <h5>Here you can edit your reviews, update you account and so much more...</h5>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- Here is reviews tab -->
                <div class="tab-pane " id="reviews">
                    @include('user.my_reviews',  ['user' => $user])
                </div>

                <!-- Here is locations tab -->
                <div class="tab-pane " id="locations">
                    @include('user.my_locations',  ['user' => $user])
                </div>

                <!-- Here is places tab -->
                <div class="tab-pane" id="places">
                    @include('user.my_places',  ['user' => $user])
                </div>

                <!-- Here is settings tab -->
                <div class="tab-pane" id="settings">
                    @include('user.user_settings',  ['user' => $user])
                </div>
                @foreach($user->reviews as $review)
                    @include('reviews.my_review',  ['review' => $review])
                @endforeach
                @foreach($user->places as $place)
                    @include('places.details',  ['place' => $place])
                @endforeach
                @foreach($user->locations as $location)
                    @include('locations.edit',  ['location' => $location])
                @endforeach
                @include('locations.create')

            </div>
        </div>

    </div>
@endsection
