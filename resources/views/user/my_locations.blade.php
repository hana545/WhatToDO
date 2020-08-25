<div class="text-white">
    <div class="card-header text-center">
        @if(Auth::user()->suspended == false)
            @if($user->locations->first())
                <h4>{{ __('This is a list of all your places') }}</h4>
            @else
                <h4>{{ __('You didnt save any location. Save some') }}</h4>
            @endif
        @else
            <h4 class="text-danger">{{ __('Suspended user') }}</h4>
        @endif
    </div>

    <div class="card-body">
            <ul>
                @foreach($user->locations as $location)
                    <li class="row py-1">
                        <div class="col-4">

                            {{$location->name}}
                        </div>
                        <div class="col-5">
                            {{$location->address}}
                        </div>
                        <form action="/location/delete/{{$location->id}}" method="post" class="col-3">
                            <button type="button" class="btn btn-blue btn-sm my-2 ml-4 center-block" data-toggle="modal" data-target="#modal{{$place->id}}">Details</button>
                            @if(Auth::user()->suspended == false)<div class="btn  btn-sm  btn-blue" data-toggle="modal" data-target="#modalLocation{{$location->id}}">Edit</div>@endif
                            <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                            @method('delete')
                            @csrf
                        </form>
                    </li>
                    <hr class="light-muted-100">

                @endforeach
            </ul>
            @if(Auth::user()->suspended == false)
                <div class="card text-white bg mb-3 group-card" style="background-color: cadetblue">
                    <a href="#" style="color: white" data-toggle="modal" data-target="#modalNewLocation">

                        <div class="card-body text-center">
                            <h5 class="card-title">Save a new location</h5>
                            <p class="card-text"><i class="fas fa-marker fa-3x"></i></p>
                        </div>
                    </a>
                </div>
            @endif

    </div>
</div>
