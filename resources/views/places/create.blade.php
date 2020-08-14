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
            <form action="{{route('store_object')}}" method="POST" class="px-2 mx-1 row" enctype="multipart/form-data">
                <div class="col-md">
                    <label for='name'>Name:</label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                        </div>
                        <input type="text" name="name" value="{{ old('name', $place->name ?? '')}}" class="form-control" >
                    </div>
                    <div class="text-danger pb-3">{{ $errors->first('name') }}</div>

                    <label class="" for='address'>address:</label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-light" ><i class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" name="address" id="event_address" value="{{ old('address', $place->address ?? '')}}" class="form-control" >
                        <input type="text" name="lat" id="event_address" value="{{ old('address', $place->address ?? '')}}" class="form-control" >
                        <input type="text" name="lng" id="event_address" value="{{ old('address', $place->address ?? '')}}" class="form-control" >
                    </div>
                    <div class="text-danger pb-3">{{ $errors->first('address') }}</div>

                    <label class="" for='description'>Description:</label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  bg-light" ><i class="fas fa-align-center"></i></span>
                        </div>
                        <textarea type="text" class="form-control" name="description" rows="3">{{ old('description', $place->description ?? '')}} </textarea>
                    </div>
                    <div class="text-danger pb-3">{{ $errors->first('description') }}</div>

                    <div class="row pb-5">
                        <div class="col-sm-4">
                            <label for='phone'>Phone:</label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="phone1" value="{{ old('phone1', $place->phone ?? '')}}" class="form-control" required>
                                <div class="text-danger pb-3">{{ $errors->first('phone1') }}</div>
                            </div>
                            <div class="form-group input-group" v-if="seenPhone">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="phone2" value="{{ old('phone2', $place->phone ?? '')}}" class="form-control" >
                                <div class="text-danger pb-3">{{ $errors->first('phone2') }}</div>
                            </div>

                            <div class="btn btn-secondary btn-sm" v-on:click="seenPhone = !seenPhone">
                                <label  v-if="!seenPhone">@{{ addmore }} phone</label>
                                <label  v-else-if="seenPhone">@{{ remove }} phone</label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for='name'>E-mail:</label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="email1" value="{{ old('email1', $place->email ?? '')}}" class="form-control" >
                                <div class="text-danger pb-3">{{ $errors->first('email1') }}</div>
                            </div>
                            <div class="form-group input-group" v-if="seenEmail">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="email2" value="{{ old('email2', $place->email ?? '')}}" class="form-control" >
                                <div class="text-danger pb-3">{{ $errors->first('email2') }}</div>
                            </div>

                            <div class="btn btn-secondary btn-sm" v-on:click="seenEmail = !seenEmail">
                                <label  v-if="!seenEmail">@{{ addmore }} email</label>
                                <label  v-else-if="seenEmail">@{{ remove }} email</label>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <label for='name'>Website:</label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="website1" value="{{ old('website1', $place->website ?? '')}}" placeholder="Place URL" class="form-control" >
                                <div class="text-danger pb-3">{{ $errors->first('website2') }}</div>
                            </div>
                            <div class="form-group input-group" v-if="seenWebsite">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-light"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" name="website2" value="{{ old('website2', $place->website ?? '')}}" placeholder="Place URL" class="form-control" >
                                <div class="text-danger pb-3">{{ $errors->first('website2') }}</div>
                            </div>

                            <div class="btn btn-secondary btn-sm" v-on:click="seenWebsite = !seenWebsite">
                                <label  v-if="!seenWebsite">@{{ addmore }} website</label>
                                <label  v-else-if="seenWebsite">@{{ remove }} website</label>
                            </div>
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


                <label class="" for='picture'>Choose picture or leave blank for default:</label>
                <div class="form-group input-group" id="length_filename" style="width: 40%">
                    <div class="input-group-prepend">
                        <span class="input-group-text  bg-light" ><i class="fas fa-image"></i></span>
                    </div>

                    <label class ="image_button form-control col" for="picture"> Upload image
                        <input type="file" class="inputfileevent form-control" id="picture" name="picture" autocomplete="picture">
                        <span id="file-upload-filename" class="col file-upload-filename" style="display: none"></span>
                    </label>
                </div>
                <div class="text-danger pb-3">{{ $errors->first('picture') }}</div>
                slike
                profile image


                <label class="" for="category"></label>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light" ><i class="fas fa-th-list"></i></span>
                    </div>
                    <select name ="category" class="form-control">
                        <option value="" disabled="" selected>Select category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if (old('category') == $category->id) selected @endif >{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-danger pb-3">{{ $errors->first('category') }}</div>
                <label class="" for="tags">Select appropriate tags min 3</label>
                <div class="form-group input-group">
                <div class="input-group-prepend">
                    <div class="btn-group-toggle mb-2 row justify-content-around" data-toggle="buttons">
                        @foreach ($tags as $tag)
                            <label class="btn btn-secondary col-auto px-4">
                                <input type="checkbox" name="tag[]"
                                       value=" {{$tag->id}}">
                                {{ $tag->name}}
                            </label>

                        @endforeach
                    </div>
                    <div class="text-danger pb-3">{{ $errors->first('tag') }}</div>
                </div>

                </div>
            <button type="submit" class="btn btn-lg btn-blue-org my-2 ml-4 px-5">Add place</button>
            @csrf

            </form>
        </div>

@endsection
