
<div id="modalreview{{$place->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content background-color-darkblue" >
            <div class="modal-header text-center">
                <h3 class="modal-title card-element-title text-white"> <strong>{{$place->name}}</strong></h3>

                <button type="button" class="btn btn-secondary float-lg-left" data-dismiss="modal"><i class="fas fa-times-circle"></i></button>
            </div>
            <div class="modal-body">
                <div class=" clearfix">
                    <div class="container-fluid">
                        <div class="p-3 border-bottom text-center text-white-muted">

                            <h6>
                                <section class='rating-widget'>
                                    <!-- Rating Stars Box -->
                                    <div class='rating-stars text-center'>
                                        <ul id=''>
                                            <li class='star-static @if($place->avgStar >= 1) selected  @endif' title='Awful' data-value='1' >
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star-static @if($place->avgStar >= 2) selected  @endif' title='Bad' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star-static @if($place->avgStar >= 3) selected  @endif' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star-static @if($place->avgStar >= 4) selected  @endif' title='Very good' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star-static @if($place->avgStar >= 5) selected  @endif'  title='Excellent!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </section>
                            </h6>
                            <div>
                                @auth
                                <button type="button" id="openReview" class="btn btn-dark  btn-sm my-2 ml-4 center-block" v-if="!show" @click="toggleShow()">@if( $place->hasReview) Edit your review  @else Leave a review @endif</button>
                                @endauth
                                <form @if( $place->hasReview) action="/search/review/update/{{$place->UserReview->id}}"  @else action="/review/store/{{$place->id}}" @endif method="POST" v-show="show">
                                    <section class='rating-widget'>
                                        <!-- Rating Stars Box -->

                                        <p class="pt-1 border-top">Your review</p>
                                        <div class='rating-stars text-center'>
                                            <ul id='stars'>
                                                <li class='star  star-hover @if($place->UserReview->star >= 1)chosen  @endif' title='Awful' data-value='1'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star  star-hover  @if($place->UserReview->star >= 2)chosen  @endif' title='Bad' data-value='2'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star  star-hover  @if($place->UserReview->star >= 3)chosen  @endif' title='Good' data-value='3'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star  star-hover  @if($place->UserReview->star >= 4)chosen  @endif' title='Very good' data-value='4'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star  star-hover  @if($place->UserReview->star >= 5)chosen  @endif'  title='Excellent!!!' data-value='5'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                            </ul>
                                        </div>

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
                                        <button type="button" class="btn btn-secondary mx-2" @click="toggleShow()">Close</button>
                                        <input type="submit" class="btn btn-blue mx-2" @if( $place->hasReview) value="Update review" @else value="Post review" @endif>
                                        @if( $place->hasReview)<a href="/search/review/delete/{{$place->UserReview->id}}"><div class="btn btn-danger">Delete</div></a>@endif

                                    </div>
                                    @csrf
                                </form>
                            </div>
                            <div class="row">
                                @foreach($place->reviews as $review)
                                    <div class="col-md-2">
                                        {{ $review->created_at->format('d.m.Y') }}
                                    </div>
                                    <section class='rating-widget col-md-2'>
                                        <div class='rating-stars text-center'>
                                            <ul id='stars' class="col-md"  data-toggle="modal" data-target="#modalreview{{$place->id}}">
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





