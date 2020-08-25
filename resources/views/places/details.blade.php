
<div id="modal{{$place->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content background-color-darkblue" >
            <div class="modal-header text-center">
                <h3 class="modal-title card-element-title text-white"> <strong>{{$place->name}}</strong></h3>

                <button type="button" class="btn btn-secondary float-lg-left" data-dismiss="modal"><i class="fas fa-times-circle"></i></button>
            </div>
            <div class="modal-body">
                <div class=" clearfix">
                    <div class="container-fluid">
                        <div class="p-3 border-bottom text-center text-white-muted grey-box">
                            <h6> <i>{{ $place->description }}</i></h6>
                            <h6>
                                <section class='rating-widget'>
                                    <!-- Rating Stars Box -->
                                    <div class='rating-stars text-center'>
                                        <ul id='stars'>
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

                        </div>
                        <div class="row">
                            <div class="col-4  text-center border-right text-white">
                                <div class="p-2 mt-2">
                                    <p> <i class="fas fa-map-marker-alt"></i> <strong>Location: </strong></p>
                                </div>
                            </div>
                            <div class="col-8  text-center text-white">
                                <div class="p-2 mt-2">
                                    <p>{{ $place->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-4   text-center border-right text-white">
                                <div class="p-2">
                                    <p> <i class="fas fa-tag"></i><strong> Category:</strong></p>
                                </div>
                            </div>
                            <div class="col-8  text-center text-white">
                                <div class="p-2">
                                    <p>{{ $place->category->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-4   text-center border-right text-white">
                                <div class="p-2">
                                    <p> <i class="fas fa-hashtag"></i> <strong>Tags:</strong></p>
                                </div>
                            </div>
                            <div class="col-8  text-center text-white">
                                @foreach($place->tags as $tag)
                                    <label class="btn blue-tag col-auto px-2 m-1">
                                        {{ $tag->name}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @if ($place->phones->isNotEmpty() || $place->emails->isNotEmpty() || $place->website->isNotEmpty())
                        <div class="p-3 border-bottom border-top text-center text-white-muted grey-box">
                            <h6> <i>Contact</i></h6>
                        </div>
                        @if($place->phones->isNotEmpty())
                            <div class="row">
                                <div class="col-4   text-center border-right text-white">
                                    <div class="p-2 mt-2">
                                        <p> <i class="fas fa-th-list"></i> <strong>Phone:</strong></p>
                                    </div>
                                </div>
                                <div class="col-8   text-center text-white">
                                    @foreach($place->phones as $phone)
                                        <div class="p-2">
                                            <p>{{ $phone->number}}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($place->emails->isNotEmpty())
                            <div class="row">
                                <div class="col-4   text-center border-right text-white">
                                    <div class="p-2">
                                        <p> <i class="fas fa-th-list"></i> <strong>Email:</strong></p>
                                    </div>
                                </div>
                                <div class="col-8   text-center text-white">
                                    @foreach($place->emails as $email)
                                        <div class="p-2">
                                            <p>{{ $email->email}}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($place->website->isNotEmpty())
                            <div class="row">
                                <div class="col-4   text-center border-right text-white">
                                    <div class="p-2">
                                        <p> <i class="fas fa-th-list"></i> <strong>Websites:</strong></p>
                                    </div>
                                </div>
                                <div class="col-8  text-center text-white">
                                    @foreach($place->website as $website)
                                        <div class="p-2">
                                            <p><a href="{{ $website->url}}">{{ $website->url}}</a></p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @else
                            <div class="p-3 border-bottom border-top text-center text-white-muted grey-box">
                                <h6> <i>There are no contacts</i></h6>
                            </div>
                        @endif
                        @include('places.workhours', ['place' => $place])
                        @if($place->images)
                            <div class="p-3 border-bottom border-top text-center text-white-muted grey-box">
                                <h6> <i>Pictures</i></h6>
                            </div>
                            <div class="justify-content-center">
                                <a class="btn btn-blue mt-3 mb-2" data-toggle="collapse" href="#collapseGallery" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Open for gallery <i class="fas fa-images"></i>
                                </a>
                            </div>


                            <div class="collapse ml-3" id="collapseGallery">
                                <div class="row">

                                    @foreach(json_decode($place->images) as $pic)
                                            <div class="col-lg-3 col-md-4 col-6">
                                                <a data-fancybox="gallery" href="{{ asset('storage/'.$pic) }}" class="d-block mb-4 h-100">
                                                    <!-- 170 * 120 -->
                                                    <img class="img-thumbnail zoom" src="{{ asset('storage/'.$pic) }}" style="max-width: 100%; min-height: 120px">
                                                </a>
                                            </div>
                                    @endforeach

                                </div>
                            </div>
                        @else
                            <div class="p-3 border-bottom border-top text-center text-white-muted grey-box">
                                <h6> <i>There are no pictures</i></h6>
                            </div>
                        @endif

                    </div>
                </div>
            </div>


            <div class="modal-footer">
                @if (Auth::check() && Auth::user()->type == true)
                    <form action="/search/place/delete/{{$place->id}}" method="post">
                        <input class="btn btn-danger" type="submit" value="Delete this place" />
                        @method('delete')
                        @csrf
                    </form>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>





