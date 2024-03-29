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
                    <form action="{{route('store_object')}}"  method="POST" class="px-2 mx-1 row card-body" enctype="multipart/form-data">
                        <div class="col-md">
                            <label for='name'>Name: <span class="text-danger">*</span></label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="name" value="{{ old('name')}}" class="form-control" >
                            </div>
                            <div class="text-danger pb-3">{{ $errors->first('name') }}</div>

                            <label class="" for='address'>Address: <span class="text-danger">*</span></label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light" ><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="address" id="google_address" value="{{ old('address')}}" class="form-control" >
                               </div>
                            <div class="text-danger pb-3">{{ $errors->first('address') }}</div>

                            <label class="" for='description'>Description: <span class="text-danger">*</span></label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light" ><i class="fas fa-align-center"></i></span>
                                </div>
                                <textarea type="text" class="form-control" name="description" rows="3">{{ old('description')}} </textarea>
                            </div>
                            <div class="text-danger pb-3">{{ $errors->first('description') }}</div>

                            <div class="row pb-5">
                                <div class="col-sm-4">
                                    <label for='phone'>Phone:</label>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                        <input type="tel" name="phone1" value="{{ old('phone1')}}" class="form-control"  placeholder="1." >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('phone1') }}</div>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                        <input type="tel" name="phone2" value="{{ old('phone2')}}" class="form-control" placeholder="2."  >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('phone2') }}</div>

                                </div>

                                <div class="col-sm-4">
                                    <label for='name'>E-mail:</label>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-at"></i></span>
                                        </div>
                                        <input type="text" name="email1" value="{{ old('email1')}}" class="form-control" placeholder="1.">
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('email1') }}</div>
                                    <div class="form-group input-group" >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-at"></i></span>
                                        </div>
                                        <input type="text" name="email2" value="{{ old('email2')}}" class="form-control" placeholder="2." >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('email2') }}</div>

                                </div>

                                <div class="col-sm-4">
                                    <label for='name'>Website:</label>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-link"></i></i></span>
                                        </div>
                                        <input type="text" name="website1" value="{{ old('website1')}}" placeholder="Place URL" class="form-control" >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('website1') }}</div>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-light"><i class="fas fa-link"></i></span>
                                        </div>
                                        <input type="text" name="website2" value="{{ old('website2')}}" placeholder="Place URL" class="form-control" >
                                    </div>
                                    <div class="text-danger pb-3">{{ $errors->first('website2') }}</div>

                                </div>
                            </div>

                        <div class="form-group input-group justify-content-center">
                            <label for='workhours' class="pb-3 mb-4"><h5><i class="fa fa-clock"></i> Workhours:</h5></label>
                                <ul style="width: 100%">
                                    <div class="row grey-box">
                                        <label  class="col-md-3 text-center">Monday</label>
                                        <span class="col-md-1 text-center"></span>
                                        <input type="time" name="monday-start1"  class="col-md-3" value="{{old('monday-start1')}}"  >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="monday-end1"  class="col-md-3" value="{{old('monday-end1')}}" >
                                         </div>

                                    @if( $errors->first('monday-start1'))<div class="text-danger pb-3">{{ $errors->first('monday-start1') }}</div> @endif @if( $errors->first('monday-end1') )<div class="text-danger pb-3">{{ $errors->first('monday-end1') }}</div>@endif
                                    <div class="row  mb-2" >
                                        <label  class="col-md-3 text-center"></label>
                                        <span class="col-md-1 text-right"><i class="fas fa-plus-square"></i></span>
                                        <input type="time" name="monday-start2"  class="col-md-3" value="{{old('monday-start2')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="monday-end2"  class="col-md-3" value="{{old('monday-end2')}}" ></div>

                                    @if( $errors->first('monday-start2'))<div class="text-danger pb-3">{{ $errors->first('monday-start2') }}</div> @endif @if( $errors->first('monday-end2') )<div class="text-danger pb-3">{{ $errors->first('monday-end2') }}</div>@endif

                                    <div class="row grey-box ">
                                        <label  class="col-md-3 text-center" >Tuesday</label>
                                        <span class="col-md-1 text-center"></span>
                                        <input type="time" name="tuesday-start1" class="col-md-3"  value="{{old('tuesday-start1')}}"  >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="tuesday-end1"  class="col-md-3"  value="{{old('tuesday-end1')}}" ></div>
                                    @if( $errors->first('tuesday-start1'))<div class="text-danger pb-3">{{ $errors->first('tuesday-start1') }}</div> @endif @if( $errors->first('tuesday-end1') )<div class="text-danger pb-3">{{ $errors->first('tuesday-end1') }}</div>@endif
                                    <div class="row  mb-1">
                                        <label  class="col-md-3 text-center" ></label>
                                        <span class="col-md-1 text-right"><i class="fas fa-plus-square"></i></span>
                                        <input type="time" name="tuesday-start2" class="col-md-3"   value="{{old('tuesday-start2')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="tuesday-end2"  class="col-md-3" value="{{old('tuesday-end2')}}" ></div>
                                    @if( $errors->first('tuesday-start2'))<div class="text-danger pb-3">{{ $errors->first('tuesday-start2') }}</div> @endif @if( $errors->first('tuesday-end2') )<div class="text-danger pb-3">{{ $errors->first('tuesday-end2') }}</div>@endif

                                    <div class="row grey-box">
                                        <label  class="col-md-3 text-center">Wednesday</label>
                                        <span class="col-md-1 text-center"></span>
                                        <input type="time" name="wednesday-start1" class="col-md-3" value="{{old('wednesday-start1')}}"  >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="wednesday-end1"  class="col-md-3"  value="{{old('wednesday-end1')}}"  ></div>
                                    @if( $errors->first('wednesday-start1'))<div class="text-danger pb-3">{{ $errors->first('wednesday-start1') }}</div> @endif @if( $errors->first('wednesday-end1') )<div class="text-danger pb-3">{{ $errors->first('wednesday-end1') }}</div>@endif
                                    <div class="row  mb-1" >
                                        <label  class="col-md-3 text-center" ></label>
                                        <span class="col-md-1 text-right"><i class="fas fa-plus-square"></i></span>
                                        <input type="time" name="wednesday-start2" class="col-md-3" value="{{old('wednesday-start2')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="wednesday-end2"  class="col-md-3" value="{{old('wednesday-end2')}}" ></div>
                                    @if( $errors->first('wednesday-start2'))<div class="text-danger pb-3">{{ $errors->first('wednesday-start2') }}</div> @endif @if( $errors->first('wednesday-end2') )<div class="text-danger pb-3">{{ $errors->first('wednesday-end2') }}</div>@endif

                                    <div class="row grey-box">
                                        <label  class="col-md-3 text-center">Thursday</label>
                                        <span class="col-md-1 text-center"></span>
                                        <input type="time" name="thursday-start1" class="col-md-3" value="{{old('thursday-start1')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="thursday-end1"  class="col-md-3" value="{{old('thursday-end1')}}"  ></div>
                                    @if( $errors->first('thursday-start1'))<div class="text-danger pb-3">{{ $errors->first('thursday-start1') }}</div> @endif @if( $errors->first('thursday-end1') )<div class="text-danger pb-3">{{ $errors->first('thursday-end1') }}</div>@endif
                                    <div class="row  mb-1" >
                                        <label  class="col-md-3 text-center" ></label>
                                        <span class="col-md-1 text-right"><i class="fas fa-plus-square"></i></span>
                                        <input type="time" name="thursday-start2" class="col-md-3" value="{{old('thursday-start2')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="thursday-end2"  class="col-md-3" value="{{old('thursday-end2')}}" ></div>
                                    @if( $errors->first('thursday-start2'))<div class="text-danger pb-3">{{ $errors->first('thursday-start2') }}</div> @endif @if( $errors->first('thursday-end2') )<div class="text-danger pb-3">{{ $errors->first('thursday-end2') }}</div>@endif

                                    <div class="row grey-box">
                                        <label  class="col-md-3 text-center">Friday</label>
                                        <span class="col-md-1 text-center"></span>
                                        <input type="time" name="friday-start1" class="col-md-3" value="{{old('friday-start1')}}">
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="friday-end1"  class="col-md-3" value="{{old('friday-end1')}}"  ></div>
                                    @if( $errors->first('friday-start1'))<div class="text-danger pb-3">{{ $errors->first('friday-start1') }}</div> @endif @if( $errors->first('friday-end1') )<div class="text-danger pb-3">{{ $errors->first('friday-end1') }}</div>@endif
                                    <div class="row  mb-1" >
                                        <label  class="col-md-3 text-center"></label>
                                        <span class="col-md-1 text-right"><i class="fas fa-plus-square"></i></span>
                                        <input type="time" name="friday-start2" class="col-md-3"  value="{{old('friday-start2')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="friday-end2"  class="col-md-3" value="{{old('friday-end2')}}" ></div>
                                    @if( $errors->first('friday-start2'))<div class="text-danger pb-3">{{ $errors->first('friday-start2') }}</div> @endif @if( $errors->first('friday-end2') )<div class="text-danger pb-3">{{ $errors->first('friday-end2') }}</div>@endif

                                    <div class="row grey-box">
                                        <label  class="col-md-3 text-center">Saturday</label>
                                        <span class="col-md-1 text-center"></span>
                                        <input type="time" name="saturday-start1" class="col-md-3" value="{{old('saturday-start1')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="saturday-end1"  class="col-md-3" value="{{old('saturday-end1')}}" ></div>
                                    @if( $errors->first('saturday-start1'))<div class="text-danger pb-3">{{ $errors->first('saturday-start1') }}</div> @endif @if( $errors->first('saturday-end1') )<div class="text-danger pb-3">{{ $errors->first('saturday-end1') }}</div>@endif
                                    <div class="row  mb-1">
                                        <label  class="col-md-3 text-center" ></label>
                                        <span class="col-md-1 text-right"><i class="fas fa-plus-square"></i></span>
                                        <input type="time" name="saturday-start2" class="col-md-3" value="{{old('saturday-start2')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="saturday-end2"  class="col-md-3"  value="{{old('saturday-end2')}}" ></div>
                                    @if( $errors->first('saturday-start2'))<div class="text-danger pb-3">{{ $errors->first('saturday-start2') }}</div> @endif @if( $errors->first('saturday-end2') )<div class="text-danger pb-3">{{ $errors->first('saturday-end2') }}</div>@endif

                                    <div class="row grey-box">
                                        <label  class="col-md-3 text-center">Sunday</label>
                                        <span class="col-md-1 text-center"></span>
                                        <input type="time" name="sunday-start1" class="col-md-3" value="{{old('sunday-start1')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="sunday-end1"  class="col-md-3" value="{{old('sunday-end1')}}"  ></div>
                                    @if( $errors->first('sunday-start1'))<div class="text-danger pb-3">{{ $errors->first('sunday-start1') }}</div> @endif @if( $errors->first('sunday-end1') )<div class="text-danger pb-3">{{ $errors->first('sunday-end1') }}</div>@endif
                                    <div class="row  mb-1">
                                        <label  class="col-md-3 text-center" ></label>
                                        <span class="col-md-1 text-right"><i class="fas fa-plus-square"></i></span>
                                        <input type="time" name="sunday-start2" class="col-md-3" value="{{old('sunday-start2')}}" >
                                        <span class="col-md-1 text-center"><i class="fas fa-minus"></i></span>
                                        <input type="time" name="sunday-end2"  class="col-md-3" value="{{old('sunday-end2')}}" ></div>
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
                                    <option value="{{$category->id}}" @if (old('category') == $category->id) selected @endif>
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-danger pb-3">{{ $errors->first('category') }}</div>


                        <label class="" for="tags">Select appropriate tags</label>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <div class="btn-group-toggle mb-2 row justify-content-around" data-toggle="buttons">
                                    @foreach ($tags as $tag)
                                        <label class="btn btn-blue-check col-auto px-2 m-1">
                                            <input type="checkbox" name="tag[]"
                                                   value=" {{$tag->id}}"  @if(old('tag')) @if(in_array($tag->id, old('tag', $place->tags))) checked @endif @endif>
                                            {{ $tag->name}}
                                        </label>
                                    @endforeach
                                </div>
                                <div class="text-danger pb-3">{{ $errors->first('tag') }}</div>
                            </div>
                        </div>

                    <button type="submit" class="btn btn-lg btn-blue my-2 ml-4 px-5">Add place</button>
                    @csrf

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
