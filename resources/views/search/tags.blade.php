<div class="btn-group-toggle mb-2 row justify-content-around" data-toggle="buttons">
    @foreach ($tags as $tag)
        <label class="btn btn-outline-bluelight-org col-auto px-4">
            <input type="checkbox" name="tag[]"
                   value=" {{$tag->id}}">
            {{ $tag->name}}
        </label>

    @endforeach
</div>

