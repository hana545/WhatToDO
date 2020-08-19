<div class="btn-group-toggle mb-2 row justify-content-around" data-toggle="buttons">
    @foreach ($tags as $tag)
        <label class="btn btn-blue-check col-auto px-2 m-1">
            <input type="checkbox" name="tag[]"
                   value=" {{$tag->id}}"  @if(!empty($tags_req))
                   @foreach($tags_req as $checked)
                   @if($tag->id == $checked) checked @endif
                @endforeach
                @endif>
            {{ $tag->name}}
        </label>

    @endforeach
</div>

