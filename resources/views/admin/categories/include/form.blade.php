<div class="col-md-12">
    <div class="form-group">
        <label for="title">{{ __('Judul Kategori') }}</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ isset($category) ? $category->title : old('title') }}" required />
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="description">{{ __('Deskripsi Kategori') }}</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ isset($category) ? $category->description : old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
