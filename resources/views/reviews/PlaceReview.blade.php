
<div id="modalreview{{$place->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content background-color-darkblue" >
            <div class="modal-header text-center">
                <h3 class="modal-title card-element-title text-white"> <strong>{{$place->name}} </strong></h3>

                <button type="button" class="btn btn-secondary float-lg-left" data-dismiss="modal"><i class="fas fa-times-circle"></i></button>
            </div>
            <div class="modal-body">
                <div class=" clearfix">
                    <div class="container-fluid">
                        <div class="p-3 border-bottom text-center text-white-muted">
                            <div>
                                @auth
                                    <h4 type="button" class="pt-2 my-2" >@if( $place->hasReview) Edit your review  @else Leave a review @endif</h4>
                                    <form @if( $place->hasReview) action="/search/review/update/{{$place->UserReview->id}}"  @else action="/review/store/{{$place->id}}" @endif method="POST">
                                        <section class='rating-widget'>
                                            <!-- Rating Stars Box -->
                                            @include('reviews.star_hover_rating', ['star' => $place->avgStar ?? 0])

                                            <div class='success-box'>
                                                <img alt='tick image'class="tick_image" width='32' style="display: none;"/>
                                                <div class='text-message'>@if($place->hasReview)  Thanks! You rated this place with {{$place->UserReview->star}} stars. @endif</div>

                                            </div>

                                            <label class="" for='text_review'>Tell us what you think</label>
                                            <div class="form-group input-group">
                                                <textarea type="text" class="form-control" name="text_review" rows="3">{{$place->UserReview->description}}</textarea>
                                            </div>

                                        </section>

                                        <input type="number" class="StarValue" name="starvalue" @if( $place->hasReview) value="{{$place->UserReview->star}}" @else value="0" @endif  style="display: none">

                                        <div class="row mb-4 justify-content-center">
                                            <input type="submit" class="btn btn-blue mx-2" @if( $place->hasReview) value="Update review" @else value="Post review" @endif>
                                            @if( $place->hasReview)<a href="/search/review/delete/{{$place->UserReview->id}}"><div class="btn btn-danger">Delete</div></a>@endif

                                        </div>
                                        @csrf
                                    </form>
                                @endauth
                                    <h6>
                                        <label class="pb-1">Average review</label>
                                        @include('reviews.star_static_rating', ['star' => $place->avgStar ?? 0])
                                    </h6>
                            </div>
                            <div class="row">
                                @foreach($place->reviews as $review)
                                    <div class="col-md-2">
                                        {{ $review->created_at->format('d.m.Y') }}
                                    </div>
                                    <section class='rating-widget col-md-2'>
                                        @include('reviews.star_small_rating', ['star' => $review->star ?? 0])
                                    </section>
                                    <div class="col-md-4 border-right">

                                        {{$review->description}}
                                    </div>
                                    <div class="col-md-3">
                                       {{$review->user->name}}
                                    </div>
                                    <div class="col-md-1">

                                        @if (Auth::check() && Auth::user()->type == true)
                                            <form action="/search/review/delete/{{$review->id}}" method="post">
                                                <button class="btn btn-sm btn-danger" type="submit" ><i class="fa fa-trash"></i></button>
                                                @method('delete')
                                                @csrf
                                            </form>
                                        @endif
                                    </div>

                                @endforeach
                            </div>
                        </div>




                    </div>
                </div>
            </div>


            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</div>





