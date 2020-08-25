@extends('layouts.app')

<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();

?>
@section('content')


    <div class="container-fluid pt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-white grey-box-card pt-3">
                    <div class="card-header text-center">
                        <h2>Create new place</br></h2>
                    </div>

                    <form @if(!$update) action="{{route('store_object')}}" @else action="/place/update/{{$place->id}}" @endif method="POST" class="px-2 mx-1 row card-body" enctype="multipart/form-data">
                        <div class="col-md">
                            <label for='name'>Name: <span class="text-danger">*</span></label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $place->name ?? '')}}" class="form-control" >
                            </div>
                            <div class="text-danger pb-3">{{ $errors->first('name') }}</div>

                            <label class="" for='address'>Address: <span class="text-danger">*</span></label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light" ><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="address" id="google_address" value="{{ old('address', $place->address ?? '')}}" class="form-control" >
                               </div>
                            <div class="text-danger pb-3">{{ $errors->first('address') }}</div>

                            <label class="" for='description'>Description: <span class="text-danger">*</span></label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light" ><i class="fas fa-align-center"></i></span>
                                </div>
                                <textarea type="text" class="form-control" name="description" rows="3">{{ old('description', $place->description ?? '')}} </textarea>
                            </div>
                            <div class="text-danger pb-3">{{ $errors->first('description') }}</div>
                            @php
                                foreach($place->phones as $val => $phone){
                                    if($val == 0)$phone1 = $phone;
                                    if($val == 1)$phone2 = $phone;
                                }
                            @endphp
                            <div class="row pb-5">
                                <div class="col-sm-4">
                                    <label for='phone'>Phone:</label>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                        <input type="tel" name="phone1" value="{{ old('phone1', $phone1->number ?? '')}}" class="form-control"  placeholder="1." >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('phone1') }}</div>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                        <input type="tel" name="phone2" value="{{ old('phone2', $phone2->number ?? '')}}" class="form-control" placeholder="2."  >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('phone2') }}</div>

                                </div>
                                @php
                                    foreach($place->emails as $val => $email){
                                        if($val == 0)$email1 = $email;
                                        if($val == 1)$email2 = $email;
                                    }
                                @endphp
                                <div class="col-sm-4">
                                    <label for='name'>E-mail:</label>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-at"></i></span>
                                        </div>
                                        <input type="text" name="email1" value="{{ old('email1',$email1->email ?? '')}}" class="form-control" placeholder="1.">
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('email1') }}</div>
                                    <div class="form-group input-group" >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-at"></i></i></span>
                                        </div>
                                        <input type="text" name="email2" value="{{ old('email2',$email2->email ?? '')}}" class="form-control" placeholder="2." >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('email2') }}</div>

                                </div>
                                @php
                                    foreach($place->website as $val => $website){
                                        if($val == 0)$website1 = $website;
                                        if($val == 1)$website2 = $website;
                                    }
                                @endphp

                                <div class="col-sm-4">
                                    <label for='name'>Website:</label>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-link"></i></i></span>
                                        </div>
                                        <input type="text" name="website1" value="{{ old('website1', $website1->url ?? '')}}" placeholder="Place URL" class="form-control" >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('website2') }}</div>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-link"></i></span>
                                        </div>
                                        <input type="text" name="website2" value="{{ old('website2', $website2->url ?? '')}}" placeholder="Place URL" class="form-control" >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('website2') }}</div>


                                </div>


                            </div>


                        <label for='workhours'>Workhours:</label>
                        <div class="form-group input-group">

                                <ul style="width: 70%">
{{in_array('monday_start1', $place->workhours)}}
                                    <div class="row"><label  class="col-md-4 text-center">Monday</label>
                                        <input type="time" name="monday-start1"  class="col-md-4"  @if(in_array('monday_start1', $place->workhours) && !old('monday-start1')) value="{{$place->workhour->monday_start1->format('H:i')}}" @else value="{{old('monday-start1')}}" @endif >
                                        <input type="time" name="monday-end1"  class="col-md-4" @if(in_array('monday_end1', $place->workhours) && !old('monday-end1')) value="{{$place->workhour->monday_end1->format('H:i')}}" @else value="{{old('monday-end1')}}" @endif > </div>
                                    @if( $errors->first('monday-start1'))<div class="text-danger pb-3">{{ $errors->first('monday-start1') }}</div> @endif @if( $errors->first('monday-end1') )<div class="text-danger pb-3">{{ $errors->first('monday-end1') }}</div>@endif
                                    <div class="row  mb-1"><label  class="col-md-4 text-center"></label>
                                        <input type="time" name="monday-start2"  class="col-md-4" @if(in_array('monday_start2', $place->workhours)) && !old('monday-start2')) value="{{$place->workhour->monday_start2->format('H:i')}}" @else value="{{old('monday-start2')}}" @endif>
                                        <input type="time" name="monday-end2"  class="col-md-4" @if(in_array('monday_end2', $place->workhours) && !old('monday-end2')) value="{{$place->workhour->monday_end2->format('H:i')}}" @else value="{{old('monday-end2')}}" @endif></div>
                                    @if( $errors->first('monday-start2'))<div class="text-danger pb-3">{{ $errors->first('monday-start2') }}</div> @endif @if( $errors->first('monday-end2') )<div class="text-danger pb-3">{{ $errors->first('monday-end2') }}</div>@endif

                                    <div class="row"><label  class="col-md-4 text-center">Tuesday</label>
                                        <input type="time" name="tuesday-start1" class="col-md-4"  @if(in_array('tuesday_start1', $place->workhours)  && !old('tuesday-start1')) value="{{$place->workhour->tuesday_start1->format('H:i')}}" @else value="{{old('tuesday-start1')}}" @endif >
                                        <input type="time" name="tuesday-end1"  class="col-md-4" @if(in_array('tuesday_end1', $place->workhours) && !old('tuesday-end1')) value="{{$place->workhour->tuesday_end1->format('H:i')}}" @else value="{{old('tuesday-end1')}}" @endif></div>
                                    @if( $errors->first('tuesday-start1'))<div class="text-danger pb-3">{{ $errors->first('tuesday-start1') }}</div> @endif @if( $errors->first('tuesday-end1') )<div class="text-danger pb-3">{{ $errors->first('tuesday-end1') }}</div>@endif
                                    <div class="row  mb-1"><label  class="col-md-4 text-center"></label>
                                        <input type="time" name="tuesday-start2" class="col-md-4" @if(in_array('tuesday_start2', $place->workhours) && !old('tuesday-start2')) value="{{$place->workhour->tuesday_start2->format('H:i')}}" @else value="{{old('tuesday-start2')}}" @endif>
                                        <input type="time" name="tuesday-end2"  class="col-md-4" @if(in_array('tuesday_end2', $place->workhours) && !old('tuesday-end2')) value="{{$place->workhour->tuesday_end2->format('H:i')}}" @else value="{{old('tuesday-end2')}}" @endif></div>
                                    @if( $errors->first('tuesday-start2'))<div class="text-danger pb-3">{{ $errors->first('tuesday-start2') }}</div> @endif @if( $errors->first('tuesday-end2') )<div class="text-danger pb-3">{{ $errors->first('tuesday-end2') }}</div>@endif

                                    <div class="row"><label  class="col-md-4 text-center">Wednesday</label>
                                        <input type="time" name="wednesday-start1" class="col-md-4" @if(in_array('wednesday_start1', $place->workhours)  && !old('wednesday-start1')) value="{{$place->workhour->wednesday_start1->format('H:i')}}" @else value="{{old('wednesday-start1')}}" @endif >
                                        <input type="time" name="wednesday-end1"  class="col-md-4" @if(in_array('wednesday_end1', $place->workhours) && !old('wednesday-end1')) value="{{$place->workhour->wednesday_end1->format('H:i')}}" @else value="{{old('wednesday-end1')}}" @endif ></div>
                                    @if( $errors->first('wednesday-start1'))<div class="text-danger pb-3">{{ $errors->first('wednesday-start1') }}</div> @endif @if( $errors->first('wednesday-end1') )<div class="text-danger pb-3">{{ $errors->first('wednesday-end1') }}</div>@endif
                                    <div class="row  mb-1"><label  class="col-md-4 text-center"></label>
                                        <input type="time" name="wednesday-start2" class="col-md-4" @if(in_array('wednesday_start2', $place->workhours) && !old('wednesday-start2')) value="{{$place->workhour->wednesday_start2->format('H:i')}}" @else value="{{old('wednesday-start2')}}" @endif>
                                        <input type="time" name="wednesday-end2"  class="col-md-4" @if(in_array('wednesday_end2', $place->workhours) && !old('wednesday-end2')) value="{{$place->workhour->wednesday_end2->format('H:i')}}" @else value="{{old('wednesday-end2')}}" @endif></div>
                                    @if( $errors->first('wednesday-start2'))<div class="text-danger pb-3">{{ $errors->first('wednesday-start2') }}</div> @endif @if( $errors->first('wednesday-end2') )<div class="text-danger pb-3">{{ $errors->first('wednesday-end2') }}</div>@endif

                                    <div class="row"><label  class="col-md-4 text-center">Thursday</label>
                                        <input type="time" name="thursday-start1" class="col-md-4" @if(in_array('thursday_start1', $place->workhours)  && !old('thursday-start1')) value="{{$place->workhour->thursday_start1->format('H:i')}}" @else value="{{old('thursday-start1')}}" @endif>
                                        <input type="time" name="thursday-end1"  class="col-md-4" @if(in_array('thursday_end1', $place->workhours) && !old('thursday-end1')) value="{{$place->workhour->thursday_end1->format('H:i')}}" @else value="{{old('thursday-end1')}}" @endif ></div>
                                    @if( $errors->first('thursday-start1'))<div class="text-danger pb-3">{{ $errors->first('thursday-start1') }}</div> @endif @if( $errors->first('thursday-end1') )<div class="text-danger pb-3">{{ $errors->first('thursday-end1') }}</div>@endif
                                    <div class="row  mb-1"><label  class="col-md-4 text-center "></label>
                                        <input type="time" name="thursday-start2" class="col-md-4" @if(in_array('thursday_start2', $place->workhours) && !old('thursday-start2')) value="{{$place->workhour->thursday_start2->format('H:i')}}" @else value="{{old('thursday-start2')}}" @endif>
                                        <input type="time" name="thursday-end2"  class="col-md-4" @if(in_array('thursday_end2', $place->workhours) && !old('thursday-end2')) value="{{$place->workhour->thursday_end2->format('H:i')}}" @else value="{{old('thursday-end2')}}" @endif></div>
                                    @if( $errors->first('thursday-start2'))<div class="text-danger pb-3">{{ $errors->first('thursday-start2') }}</div> @endif @if( $errors->first('thursday-end2') )<div class="text-danger pb-3">{{ $errors->first('thursday-end2') }}</div>@endif

                                    <div class="row"><label  class="col-md-4 text-center">Friday</label>
                                        <input type="time" name="friday-start1" class="col-md-4" @if(in_array('friday_start1', $place->workhours)  && !old('friday-start1')) value="{{$place->workhour->friday_start1->format('H:i')}}" @else value="{{old('friday-start1')}}" @endif>
                                        <input type="time" name="friday-end1"  class="col-md-4" @if(in_array('friday_end1', $place->workhours) && !old('friday-end1')) value="{{$place->workhour->friday_end1->format('H:i')}}" @else value="{{old('friday-end1')}}" @endif ></div>
                                    @if( $errors->first('friday-start1'))<div class="text-danger pb-3">{{ $errors->first('friday-start1') }}</div> @endif @if( $errors->first('friday-end1') )<div class="text-danger pb-3">{{ $errors->first('friday-end1') }}</div>@endif
                                    <div class="row  mb-1"><label  class="col-md-4 text-center"></label>
                                        <input type="time" name="friday-start2" class="col-md-4" @if(in_array('friday_start2', $place->workhours) && !old('friday-start2')) value="{{$place->workhour->friday_start2->format('H:i')}}" @else value="{{old('friday-start2')}}" @endif>
                                        <input type="time" name="friday-end2"  class="col-md-4" @if(in_array('friday_end2', $place->workhours) && !old('friday-end2')) value="{{$place->workhour->friday_end2->format('H:i')}}" @else value="{{old('friday-end2')}}" @endif></div>
                                    @if( $errors->first('friday-start2'))<div class="text-danger pb-3">{{ $errors->first('friday-start2') }}</div> @endif @if( $errors->first('friday-end2') )<div class="text-danger pb-3">{{ $errors->first('friday-end2') }}</div>@endif

                                    <div class="row"><label  class="col-md-4 text-center">Saturday</label>
                                        <input type="time" name="saturday-start1" class="col-md-4" @if(in_array('saturday_start1', $place->workhours)  && !old('saturday-start1')) value="{{$place->workhour->saturday_start1->format('H:i')}}" @else value="{{old('saturday-start1')}}" @endif>
                                        <input type="time" name="saturday-end1"  class="col-md-4" @if(in_array('saturday_end1', $place->workhours) && !old('saturday-end1')) value="{{$place->workhour->saturday_end1->format('H:i')}}" @else value="{{old('saturday-end1')}}" @endif ></div>
                                    @if( $errors->first('saturday-start1'))<div class="text-danger pb-3">{{ $errors->first('saturday-start1') }}</div> @endif @if( $errors->first('saturday-end1') )<div class="text-danger pb-3">{{ $errors->first('saturday-end1') }}</div>@endif
                                    <div class="row  mb-1"><label  class="col-md-4 text-center"></label>
                                        <input type="time" name="saturday-start2" class="col-md-4" @if(in_array('saturday_start2', $place->workhours) && !old('saturday-start2')) value="{{$place->workhour->saturday_start2->format('H:i')}}" @else value="{{old('saturday-start2')}}" @endif>
                                        <input type="time" name="saturday-end2"  class="col-md-4" @if(in_array('saturday_end2', $place->workhours) && !old('saturday-end2')) value="{{$place->workhour->saturday_end2->format('H:i')}}" @else value="{{old('saturday-end2')}}" @endif></div>
                                    @if( $errors->first('saturday-start2'))<div class="text-danger pb-3">{{ $errors->first('saturday-start2') }}</div> @endif @if( $errors->first('saturday-end2') )<div class="text-danger pb-3">{{ $errors->first('saturday-end2') }}</div>@endif

                                    <div class="row"><label  class="col-md-4 text-center">Sunday</label>
                                        <input type="time" name="sunday-start1" class="col-md-4" @if(in_array('sunday_start1', $place->workhours)  && !old('sunday-start1')) value="{{$place->workhour->sunday_start1->format('H:i')}}" @else value="{{old('sunday-start1')}}" @endif>
                                        <input type="time" name="sunday-end1"  class="col-md-4" @if(in_array('sunday_end1', $place->workhours) && !old('sunday-end1')) value="{{$place->workhour->sunday_end1->format('H:i')}}" @else value="{{old('sunday-end1')}}" @endif ></div>
                                    @if( $errors->first('sunday-start1'))<div class="text-danger pb-3">{{ $errors->first('sunday-start1') }}</div> @endif @if( $errors->first('sunday-end1') )<div class="text-danger pb-3">{{ $errors->first('sunday-end1') }}</div>@endif
                                    <div class="row  mb-1"><label  class="col-md-4 text-center"></label>
                                        <input type="time" name="sunday-start2" class="col-md-4" @if(in_array('sunday_start2', $place->workhours) && !old('sunday-start2')) value="{{$place->workhour->sunday_start2->format('H:i')}}" @else value="{{old('sunday-start2')}}" @endif >
                                        <input type="time" name="sunday-end2"  class="col-md-4" @if(in_array('sunday_end2', $place->workhours) && !old('sunday-end2')) value="{{$place->workhour->sunday_end2->format('H:i')}}" @else value="{{old('sunday-end2')}}" @endif></div>
                                    @if( $errors->first('sunday-start2'))<div class="text-danger pb-3">{{ $errors->first('sunday-start2') }}</div> @endif @if( $errors->first('sunday-end2') )<div class="text-danger pb-3">{{ $errors->first('sunday-end2') }}</div>@endif
                                </ul>

                        </div>




                        <div class="form-group input-group" id="length_filename" style="width: 100%">
                            <div class="input-group-prepend">
                                <span class="input-group-text  bg-light" ><i class="fas fa-image"></i></span>
                            </div>

                            <label class ="image_button form-control" for="multiple_images"> Upload images
                                <input type="file" class="inputfile form-control" id="multiple_images" name="multiple_images[]" v-on:change="image_adjustment()" autocomplete="multiple_images" multiple>
                                <span id="file-upload-filename" class="col file-upload-filename" style="display: none"></span>
                            </label>
                        </div>
                        <div class="text-danger pb-3">{{ $errors->first('picture') }}</div>




                        <label class="" for="category">Category: <span class="text-danger">*</span></label>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light" ><i class="fas fa-tag"></i></span>
                            </div>
                            <select name ="category" class="form-control">
                                <option value="" disabled="" selected>Select category </option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if (old('category', $place->category->id ?? '') == $category->id) selected @endif >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-danger pb-3">{{ $errors->first('category') }}</div>


                        <label class="" for="tags">Select appropriate tags</label>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <div class="btn-group-toggle mb-2 row justify-content-around" data-toggle="buttons">
                                    @if(!$update)
                                        @foreach ($tags as $tag)
                                            <label class="btn btn-blue-check col-auto px-2 m-1">
                                                <input type="checkbox" name="tag[]"
                                                       value=" {{$tag->id}}"  @if(old('tag')) @if(in_array($tag->id, old('tag', $place->tags))) checked @endif @endif>
                                                {{ $tag->name}}
                                            </label>
                                        @endforeach
                                    @else
                                        @foreach ($tags as $tag)
                                            <label class="btn btn-blue-check col-auto px-2 m-1">
                                                <input type="checkbox" name="tag[]"
                                                       value=" {{$tag->id}}"  @foreach($place->tags as $checkedTag)
                                                                                @if($tag->id==$checkedTag->id)  checked @endif
                                                                                @endforeach @if(old('tag')) @if(in_array($tag->id, old('tag'))) checked @endif @endif>
                                                {{ $tag->name}}
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="text-danger pb-3">{{ $errors->first('tag') }}</div>
                            </div>
                        </div>

                    <button type="submit" class="btn btn-lg btn-blue my-2 ml-4 px-5">@if(!$update) Add place @else Update @endif</button>
                    @csrf

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
