<div id="modalLocation{{$location->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content background-color-darkblue" >
            <div class="modal-header text-center ">
                <h3 class="modal-title card-element-title text-white"> <strong>Edit {{$location->name}}</strong></h3>

                <button type="button" class="btn btn-secondary float-lg-left" data-dismiss="modal"><i class="fas fa-times-circle"></i></button>
            </div>
            <div class="modal-body">

                <div class="card-body text-white">
                    <form role="form" method="POST" action="/location/update/{{$location->id}}" novalidate class="form-horizontal">

                        @csrf
                        <div class="form-group row">

                            <label for="name" class="col-md-4 col-form-label text-md-right"  >Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{old('name', $location->name ?? '')}}" >
                                <div class="text-danger pb-3">{{ $errors->first('name') }}</div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control location_google" name="address" value="{{old('name', $location->address ?? '')}}">
                                <div class="text-danger pb-3">{{ $errors->first('address') }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-blue">
                                    Save
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
