
<div id="modalreview{{$review->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content background-color-darkblue" >
            <div class="modal-header text-center">
                <h3 class="modal-title card-element-title text-white"> <strong>{{$review->place->name}}</strong></h3>

                <button type="button" class="btn btn-secondary float-lg-left" data-dismiss="modal"><i class="fas fa-times-circle"></i></button>
            </div>
            <div class="modal-body">
                <div class=" clearfix">
                    <div class="container-fluid">
                        <div class="p-3 border-bottom text-center text-white-muted">
                            <div>
                               <form  action="/user/review/update/{{$review->id}}" method="POST">
                                    <section class='rating-widget'>
                                        <!-- Rating Stars Box -->

                                        <p class="pt-1 border-top">Your review</p>
                                        <div class='rating-stars text-center'>
                                            <ul id='stars'>
                                                <li class='star  star-hover @if($review->star >= 1)chosen  @endif' title='Awful' data-value='1'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star  star-hover  @if($review->star >= 2)chosen  @endif' title='Bad' data-value='2'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star  star-hover  @if($review->star >= 3)chosen  @endif' title='Good' data-value='3'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star  star-hover  @if($review->star >= 4)chosen  @endif' title='Very good' data-value='4'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star  star-hover  @if($review->star >= 5)chosen  @endif'  title='Excellent!!!' data-value='5'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class='success-box'>
                                            <img alt='tick image'class="tick_image" width='32' style="display: none;"/>
                                            <div class='text-message'> Thanks! You rated this place with {{$review->star}} stars. </div>

                                        </div>

                                        <label class="" for='text_review'>Tell us what you think</label>
                                        <div class="form-group input-group">
                                            <textarea type="text" class="form-control" name="text_review" rows="3">{{$review->description}}</textarea>
                                        </div>

                                    </section>

                                    <input type="number" class="StarValue" name="starvalue" value="{{$review->star}}"  style="display: none">

                                    <div class="row mb-4 justify-content-center">
                                        <input type="submit" class="btn btn-blue mx-2"  value="Update review">
                                    </div>
                                    @csrf
                                </form>
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





