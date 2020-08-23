<div class="text-white">
    <div class="card-header text-center">
        @if(Auth::user()->suspended == false)
            @if($user->places->first())
                <h4>{{ __('This is a list of all your places') }}</h4>
            @else
                <h4>{{ __('You didnt add any places. Add some') }}</h4>
            @endif
        @else
            <h4 class="text-danger">{{ __('Suspended user') }}</h4>
        @endif

    </div>

    <div class="card-body">
        @if($user->places->first())

            <ul>
                @foreach($user->places as $place)
                    <li class="row py-1">
                        <div class="col-md-3">

                            {{$place->name}}
                        </div>
                        <div class="col-md-4">
                            {{$place->description}}
                        </div>
                        <div class="col-md-2">
                            {{$place->approved}}
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-blue btn-sm my-2 ml-4 center-block" data-toggle="modal" data-target="#modal{{$place->id}}">Details</button>
                            @if(Auth::user()->suspended == false)<a href="/place/edit/{{$place->id}}"><div class="btn  btn-sm  btn-blue">Edit</div></a>@endif
                            <a href="/user/place/delete/{{$place->id}}"><div class="btn  btn-sm  btn-danger"><i class="fa fa-trash"></i></div></a>
                        </div>
                    </li>
                    <hr class="light-muted-100">

                @endforeach
            </ul>
        @else
            @if(Auth::user()->suspended == false)
                <div class="card text-white bg mb-3 group-card" style="background-color: cadetblue">
                    <a href="{{route('add_object')}}" style="color: white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Add a new place</h5>
                            <p class="card-text"><i class="fas fa-marker fa-3x"></i></p>
                        </div>
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>
