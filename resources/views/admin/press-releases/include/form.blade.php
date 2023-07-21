<div class="row mb-2">
    <div class="col-md-12">
        <div class="form-group">
            <label for="category_id">{{ __('Kategori') }}</label>
            <select class="form-select" name="category_id" id="category_id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Pilih kategori') }} --</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ isset($pressRelease) && $pressRelease->category_id == $category->id ? 'selected' : (old('category_id') == $category->id ? 'selected' : '') }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="title">{{ __('Judul') }}</label>
            <input type="text" name="title" id="title"
                class="form-control @error('title') is-invalid @enderror"
                value="{{ isset($pressRelease) ? $pressRelease->title : old('title') }}"
                placeholder="{{ __('Title') }}" required />
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
            <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror"
                placeholder="{{ __('Body') }}" required>{{ isset($pressRelease) ? $pressRelease->body : old('body') }}</textarea>
            @error('body')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    @isset($pressRelease)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($pressRelease->thumbnail == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Thumbnail"
                            class="rounded mb-2 mt-2" alt="Thumbnail" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/thumbnails/' . $pressRelease->thumbnail) }}" alt="Thumbnail"
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
                    id="thumbnail" required>

                @error('thumbnail')
                    <div class="invalid-feedback">
                        <i class="bx bx-radio-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">{{ __('Status') }}</label>
            <select class="form-select" name="status" id="status" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select status') }} --</option>
                <option value="Draft"
                    {{ isset($pressRelease) && $pressRelease->status == 'Draft' ? 'selected' : (old('status') == 'Draft' ? 'selected' : '') }}>
                    Draft</option>
                <option value="Published"
                    {{ isset($pressRelease) && $pressRelease->status == 'Published' ? 'selected' : (old('status') == 'Published' ? 'selected' : '') }}>
                    Published</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="published_at">{{ __('Tanggal Upload') }}</label>
            <input type="datetime-local" name="published_at" id="published_at"
                class="form-control @error('published_at') is-invalid @enderror"
                value="{{ isset($pressRelease) && $pressRelease->published_at ? $pressRelease->published_at->format('Y-m-d\TH:i') : old('published_at') }}"
                placeholder="{{ __('Published At') }}" required />
            @error('published_at')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
