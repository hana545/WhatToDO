@extends('layouts.app')

<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();

?>
@section('content')


    <div class="container-fluid p-5 jumbotron jumbotron-fluid bg-transparent">
        <div class="container justify-content-center pb-2 pr-5">
            <h1 class="text-white font-weight-bolder">Create new place</h1></br>
        </div>
        <div class=" justify-content-center card text-white grey-box-card p-5">
            <form @if(!$update) action="{{route('store_object')}}" @else action="/place/update/{{$place->id}}" @endif method="POST" class="px-2 mx-1 row" enctype="multipart/form-data">
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
                                <input type="tel" name="phone1" value="{{ old('phone1', $place->phones->first()->number ?? '')}}" class="form-control"  placeholder="1." >
                            </div>
                            <div class="text-danger pb-3">{{ $errors->first('phone1') }}</div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-phone-alt"></i></span>
                                </div>
                                <input type="tel" name="phone2" value="{{ old('phone2', $place->phones->last()->number ?? '')}}" class="form-control" placeholder="2."  >
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
                                <input type="text" name="website1" value="{{ old('website1', $place->website->first()->url ?? '')}}" placeholder="Place URL" class="form-control" >
                            </div>
                            <div class="text-danger pb-3">{{ $errors->first('website2') }}</div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-link"></i></span>
                                </div>
                                <input type="text" name="website2" value="{{ old('website2', $place->website->last()->url ?? '')}}" placeholder="Place URL" class="form-control" >
                            </div>
                            <div class="text-danger pb-3">{{ $errors->first('website2') }}</div>


                        </div>


                    </div>


                <label for='workhours'>Workhours:</label>
                <div class="form-group input-group">

                        <ul>
                            <li>Monday</li>
                            <li>Tuesday</li>
                            <li>Wednesday</li>
                            <li>Thursday</li>
                            <li>Friday</li>
                            <li>Saturday</li>
                            <li>Sunday</li>
                        </ul>

                </div>
                <div class="text-danger pb-3">{{ $errors->first('workhours') }}</div>



                <div class="form-group input-group" id="length_filename" style="width: 40%">
                    <div class="input-group-prepend">
                        <span class="input-group-text  bg-light" ><i class="fas fa-image"></i></span>
                    </div>

                    <label class ="image_button form-control col" for="multiple_images"> Upload images
                        <input type="file" class="inputfile form-control" id="multiple_images" name="multiple_images[]" autocomplete="multiple_images" multiple>
                        <span id="file-upload-filename" class="col file-upload-filename" style="display: none"></span>
                    </label>
                </div>
                <div class="text-danger pb-3">{{ $errors->first('picture') }}</div>




                <label class="" for="category">Category: <span class="text-danger">*</span></label>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light" ><i class="fas fa-th-list"></i></span>
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

@endsection
