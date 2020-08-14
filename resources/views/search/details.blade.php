
<div id="modal{{$place->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" action="{{route('search_objects')}}" method="POST">
            <div class="modal-header text-center">
                <h3 class="modal-title card-element-title text-secondary"> <strong>{{$place->name}}</strong></h3>

                <button type="button" class="btn btn-secondary float-lg-left" data-dismiss="modal"><i class="fas fa-times-circle"></i></button>
            </div>

            <div class="modal-body" >
                <div class="container">
                    <p>ovo je od {{$place->name}} kartica</p>
                    <p>ADRESA {{$place->address}}</p>
                    <p>desc {{$place->description}}</p>
                    <p> category {{$place->category->name}}</p>
                    <p> phone {{$place->phones->first()->number}}</p>
                    <p> website {{$place->website->first()->url}}</p>
                    <p>email {{$place->emails->first()->email}}</p>
                </div>
            </div>

            <div class="modal-footer">
            </div>
            </form>
        </div>
    </div>
</div>

