<div class="col-md-12">
    <div class="form-group">
        <label for="title">{{ __('Title') }}</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ isset($album) ? $album->title : old('title') }}" />
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="body">{{ __('Konten') }}</label>
        <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror">{{ isset($album) ? $album->body : old('body') }}</textarea>
        @error('body')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-md-12">
    <div class="form-group img_div">
        <label for="file">{{ __('Upload Gambar') }}</label>
        <div class="input-group mb-3">
            <input type="file" name="file[]" class="form-control @error('file') is-invalid @enderror">
            <button class="btn btn-primary btn-add-more" type="button"><i class="bi bi-plus-circle-fill"></i></button>
            @error('file')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="clone hide" style="display: none;">
        <div class="form-group control-group" style="margin-top:10px">
            <div class="input-group mb-3">
                <input type="file" name="file[]" class="form-control">
                <button class="btn btn-danger btn-remove" type="button"><i class="bi bi-trash-fill"></i></button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // button add more
            $(".btn-add-more").click(function() {
                var html = $(".clone").html();
                $(".img_div").after(html);
            });
            $("body").on("click", ".btn-remove", function() {
                $(this).parents(".control-group").remove();
            });
        });
    </script>
@endpush
