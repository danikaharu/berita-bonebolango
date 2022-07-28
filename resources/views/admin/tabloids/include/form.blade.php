<div class="row mb-2">
    <div class="col-md-12">
        <div class="form-group">
            <label for="title">{{ __('Judul') }}</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ isset($tabloid) ? $tabloid->title : old('title') }}" />
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="type">{{ __('Kategori') }}</label>
            <select class="form-select" name="type" id="type" class="form-control ">
                <option value="" selected disabled>-- {{ __('Pilih Kategori') }} --</option>

                <option value="Kambungu"
                    {{ isset($tabloid) && $tabloid->type == 'Kambungu' ? 'selected' : (old('type') == 'Kambungu' ? 'selected' : '') }}>
                    Kambungu</option>
                <option value="Bonebol Sepekan"
                    {{ isset($tabloid) && $tabloid->type == 'Bonebol Sepekan' ? 'selected' : (old('type') == 'Bonebol Sepekan' ? 'selected' : '') }}>
                    Bonebol Sepekan</option>
            </select>

        </div>
    </div>
    @isset($tabloid)
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($tabloid->thumbnail == null)
                        <img src="https://via.placeholder.com/350?text=File+Not+Available" alt="Thumbnail"
                            class="rounded mb-2 mt-2" alt="File" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/tabloids/thumbnail/' . $tabloid->thumbnail) }}"
                            alt="Thumbnail" class="rounded mb-2 mt-2" alt="File" width="200" height="150"
                            style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="thumbnail">{{ __('Thumbnail') }}</label>
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
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($tabloid->file == null)
                        <img src="https://via.placeholder.com/350?text=File+Not+Available" alt="File"
                            class="rounded mb-2 mt-2" alt="File" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <object data="{{ asset('storage/uploads/tabloids/' . $tabloid->file) }}" type="application/pdf"
                            class="rounded mb-2 mt-2" width="200" height="150"> </object>
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="file">{{ __('File') }}</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                            id="file">

                        @error('file')
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
                <label for="thumbnail">{{ __('Thumbnail') }}</label>
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
        <div class="col-md-12">
            <div class="form-group">
                <label for="file">{{ __('File') }}</label>
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                    id="file">

                @error('file')
                    <div class="invalid-feedback">
                        <i class="bx bx-radio-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    @endisset
</div>
