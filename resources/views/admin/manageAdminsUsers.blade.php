@extends('layouts.app')

@section('content')


    <div class="container">
        <div class=" order-lg-2 justify-content-center mt-5 text-light">

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

            </div>
            <ul class="nav nav-pills nav-fill" id="v-pills-tab">

                <li class="nav-item">
                    <a  data-toggle="tab" href="#users" class="nav-link p-3 btn-outline-bluedark"><h6><i class="fas fa-user"></i> Users</h6></a>
                </li>
                <li class="nav-item">
                    <a  data-toggle="tab" href="#admins" class="nav-link p-3 btn-outline-bluedark"><h6><i class="fas fa-map-marked-alt"></i> Admins</h6></a>
                </li>
                <li class="nav-item">
                    <a  data-toggle="tab" href="#add " class="nav-link p-3 btn-outline-bluedark active"><h6><i class="fas fa-user-cog"></i> Register new user</h6></a>
                </li>
            </ul>
            <hr class="my-1">

            <div class="tab-content py-2">

                <div class="tab-pane " id="users">
                    <div class="text-white">

                        <div class="card-body">
                            <ul class="">
                                @foreach($users as $user)
                                    <li class="row p-2">
                                        <div class="col-sm-3">
                                            {{$user->name}}
                                        </div>
                                        <div class='col-sm-3'>
                                            {{$user->email}}
                                        </div>
                                        @if($user->suspended == false)
                                        <div class="col-sm-2">
                                            <a href="/user/suspend/{{$user->id}}"><div class="btn btn-danger">Suspend</div></a>
                                        </div>
                                        @else
                                            <div class="col-sm-2">
                                                <a href="/user/unsuspend/{{$user->id}}"><div class="btn btn-outline-danger" style="background: honeydew">Unuspend</div></a>
                                            </div>
                                        @endif
                                    </li>
                                    <hr class="light-muted-100">
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Here is places tab -->
                <div class="tab-pane" id="admins">
                    <div class="text-white">
                        <div class="card-body">
                            <ul class="">
                                @foreach($admins as $admin)
                                    <li class="row p-2">
                                        <div class="col-md-3">
                                            {{$admin->name}}
                                        </div>
                                        <div class='col-md-3'>
                                            {{$admin->email}}
                                        </div>
                                        <div class="col-md-2">
                                            @if($admin->id != $authuser->id)<a href="#"><div class="btn btn-danger">Suspend</div></a>@endif
                                        </div>
                                    </li>
                                    <hr class="light-muted-100">
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Here is settings tab -->
                <div class="tab-pane active" id="add">

                    <div class="card-header text-center"><h2>{{ __('Register new user') }}</h2></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('registerNewUser') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    <div class="text-danger pb-3">{{ $errors->first('name') }}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">


                                    <div class="text-danger pb-3">{{ $errors->first('email') }}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    <div class="text-danger pb-3">{{ $errors->first('password') }}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_type" class="col-md-4 col-form-label text-md-right">Account Type</label>
                                <div class="btn-group-toggle mb-2 row justify-content-around ml-3  "data-toggle="buttons">
                                        <label class="btn btn-blue-check col-auto px-2 m-1">
                                            <input type="radio" name="user_type"  value=0 autocomplete="off" checked><b>User</b>
                                        </label>
                                        <label class="btn btn-blue-check col-auto px-2 m-1">
                                            <input type="radio" name="user_type"  value=1 autocomplete="off"><b>Admin</b>
                                        </label>
                                </div>

                                <div class="text-danger pb-3">{{ $errors->first('user_type') }}</div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-lg btn-lightblue w-50">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
