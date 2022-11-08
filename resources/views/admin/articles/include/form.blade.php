@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css"
        integrity="sha512-wXEyXmtKft9mEiu8LTc3+3BQ95aYbvxgvzH4IzFHOwvGlA14B6zREXD4CRmUPx8r2Z1RVUOXS47bwjsotSlZkQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #ffffff;
            background: #425ebf;
            padding: 3px 7px;
            border-radius: 3px;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }

        .bootstrap-tagsinput input {
            border: 1px solid #dce7f1;
            border-radius: 0.25rem;
            height: 38px;
            padding: 0.375rem 0.75rem;
        }
    </style>
@endpush

<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="category_id">{{ __('Kategori') }}</label>
            <select class="form-select" name="category_id" id="category_id" class="form-control">
                <option value="" selected disabled>-- {{ __('Pilih kategori') }} --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ isset($article) && $article->category_id == $category->id ? 'selected' : (old('category_id') == $category->id ? 'selected' : '') }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tag_id">{{ __('Tag') }}</label>
            <input type="text" data-role="tagsinput" name="tags" placeholder="Input Tag Disini"
                class="form-control @error('tags') is-invalid @enderror" value="{!! isset($article) ? implode(',', $article->tagNames()) : old('tags') !!}">
            @error('tags')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label for="title">{{ __('Judul') }}</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ isset($article) ? $article->title : old('title') }}" />
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
        <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror">{{ isset($article) ? $article->body : old('body') }}</textarea>
        @error('body')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
@isset($article)
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 text-center">
                @if ($article->thumbnail == null)
                    <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Thumbnail"
                        class="rounded mb-2 mt-2" alt="Thumbnail" width="200" height="150" style="object-fit: cover">
                @else
                    <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}" alt="Thumbnail"
                        class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                @endif
            </div>

            <div class="col-md-8">
                <div class="form-group ms-3">
                    <label for="thumbnail">{{ __('Gambar') }}</label>
                    <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                        id="thumbnail">

                    @error('thumbnail')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-12">
        <div class="form-group">
            <label for="thumbnail">{{ __('Gambar') }}</label>
            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                id="thumbnail">

            @error('thumbnail')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
@endisset
<div class="col-md-12">
    <div class="form-group">
        <label for="caption">{{ __('Caption') }}</label>
        <input type="text" name="caption" id="caption" class="form-control @error('caption') is-invalid @enderror"
            value="{{ isset($article) ? $article->caption : old('caption') }}" />
        @error('caption')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">{{ __('Status') }}</label>
            <select class="form-select" name="status" id="status" class="form-control">
                <option value="" selected disabled>-- {{ __('Select status') }} --</option>
                <option value="Draft"
                    {{ isset($article) && $article->status == 'Draft' ? 'selected' : (old('status') == 'Draft' ? 'selected' : '') }}>
                    Draft</option>
                @if (Auth::user()->hasRole('Admin'))
                    <option value="Published"
                        {{ isset($article) && $article->status == 'Published' ? 'selected' : (old('status') == 'Published' ? 'selected' : '') }}>
                        Published</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="published_at">{{ __('Tanggal Upload') }}</label>
            <input type="datetime-local" name="published_at" id="published_at"
                class="form-control @error('published_at') is-invalid @enderror"
                value="{{ isset($article) && $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : old('published_at') }}"
                placeholder="{{ __('Published At') }}" />
            @error('published_at')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

</div>

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"
        integrity="sha512-98e5nQTE7pmtZ3xoD5GCVKafmziXDT5WINC91MugFzF57zzBnmvGQl1N70cvdyBSWxjCOC55gq9Zn76MUgtEMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('mazer/js/extensions/summernote/plugins/summernote-image-attributes.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-id-ID.min.js"
        integrity="sha512-bdViARy+nltxu4VnqeBPWGfBN3yvL3hyo+Pi1lnQqXRkYqOwSVOl4QMU0upsfH/LO/kak7t9a7q7YsdUso+kig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const tag = $("bootstrap-tagsinput input");
        tag.addClass("form-control");

        $(document).ready(function() {
            $('#body').summernote({
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['help']],
                ],
                imageAttributes: {
                    icon: '<i class="note-icon-pencil"/>',
                    figureClass: 'figureClass',
                    figcaptionClass: 'captionClass',
                    captionText: 'Caption Goes Here.',
                    manageAspectRatio: true // true = Lock the Image Width/Height, Default to true
                },
                lang: 'id-ID',
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']], ,
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']],
                        ['custom', ['imageAttributes']],
                    ],
                },
            });
        });


        $('.note-editable').css('font-size', '1.125rem');
    </script>
@endpush
