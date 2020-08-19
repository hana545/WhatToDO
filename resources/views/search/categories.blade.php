<div class="btn-group-toggle mb-2 row justify-content-around" data-toggle="buttons">
    @foreach ($categories as $category)
                <label class="btn btn-blue-check col-auto px-2 m-1">
                    <input type="checkbox" name="category[]"
                           value=" {{$category->id}}"
                           @if(!empty($categories_req))
                               @foreach($categories_req as $checked)
                                    @if($category->id == $checked) checked @endif
                               @endforeach
                            @endif>
                    {{ $category->name}}
                </label>
    @endforeach
</div>

