<div class=" text-white">
    <div class="card-header text-center">
        @if(Auth::user()->suspended == false)
            @if($user->reviews->first())
                <h4>{{ __('This is a list of all your reviews') }}</h4>
            @else
                <h4>{{ __('You dont have any reviews yet. Go search and review') }}</h4>
            @endif
        @else
            <h4 class="text-danger">{{ __('Suspended user') }}</h4>
        @endif

    </div>

    <div class="card-body">
        @if($user->reviews->first())
            <ul class="">
                @foreach($user->reviews as $review)
                    <li class="row p-2">
                        <div class="col-md-3 p-1">

                            <h5>{{$review->place->name}}</h5>
                        </div>
                        <section class='rating-widget col-md-3'>
                            @include('reviews.star_small_rating', ['star' => $review->star ?? 0])
                        </section>
                        <div class="col-md-4">
                            {{$review->description}}
                        </div>
                        <form action="/user/review/delete/{{$review->id}}" method="post" class="col-md-2">
                            @if(Auth::user()->suspended == false)<div class="btn btn-sm btn-blue" data-toggle="modal" data-target="#modalreview{{$review->id}}">Edit</div>@endif
                            <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                            @method('delete')
                            @csrf
                        </form>
                    </li>
                    <hr class="light-muted-100">

                @endforeach
            </ul>
        @else
            @if(Auth::user()->suspended == false)
                <div class="card text-white bg mb-3 group-card" style="background-color: cadetblue">
                    <a href="{{route('search')}}" style="color: white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Search interesting places around you</h5>
                            <p class="card-text"><i class="fas fa-map-marked fa-3x"></i></p>
                        </div>
                    </a>
                </div>
            @endif
        @endif



    </div>
</div>
