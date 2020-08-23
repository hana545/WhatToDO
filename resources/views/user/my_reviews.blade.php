<div class=" text-white">
    <div class="card-header text-center">
        @if(Auth::user()->suspended == false)
            @if($user->reviews->first())
                <h4>{{ __('This is a list of all your reveiws') }}</h4>
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
                        <div class="col-md-3">

                            {{$review->place->name}}
                        </div>
                        <section class='rating-widget col-md-3'>
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
                        <div class="col-md-4">
                            {{$review->description}}
                        </div>
                        <div class="col-md-2">
                            @if(Auth::user()->suspended == false)<div class="btn btn-blue" data-toggle="modal" data-target="#modalreview{{$review->id}}">Edit</div>@endif
                            <a href="/user/review/delete/{{$review->id}}"><div class="btn btn-danger"><i class="fa fa-trash"></i></div></a>
                        </div>
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
