<div class="btn-group-toggle mb-2 row justify-content-around" data-toggle="buttons">
    @foreach ($categories as $category)
        <label class="btn btn-secondary col-auto px-4">
            <input type="checkbox" name="category[]"
                   value=" {{$category->id}}">
            {{ $category->name}}
        </label>

    @endforeach
</div>

