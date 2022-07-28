@isset($album->galleries)
    <div class="col-md-12">
        <label for="file">{{ __('Gambar Lama') }}</label>
        <div class="row text-center">
            @foreach ($album->galleries as $gallery)
                @if ($gallery->file == null)
                    <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="File" class="rounded mb-2 mt-2"
                        alt="File" width="200" height="150" style="object-fit: cover">
                @else
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <img id="img" src="{{ asset('storage/uploads/galleries/' . $gallery->file) }}"
                                    alt="File" class="rounded mb-2 mt-2 me-4" width="200" height="150"
                                    style="object-fit: cover">
                                <div class="input-group">

                                    <form action="{{ route('update-image', $gallery->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group my-2">
                                            <input name="image" onchange="file_changed()" type="file" id="selectedFile"
                                                style="display: none;" />
                                            <input class="btn btn-sm btn-secondary me-2" type="button" value="Ganti gambar"
                                                onclick="document.getElementById('selectedFile').click();" />
                                            <button id="edit-image" type="submit"
                                                class="btn btn-sm btn-success me-2 d-none">Edit</button>
                                        </div>
                                    </form>

                                    <form action="{{ route('remove-image', $gallery->id) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapusnya?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger my-2">Hapus</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endisset

@push('js')
    <script>
        function file_changed() {
            var selectedFile = document.getElementById('selectedFile').files[0];
            var img = document.getElementById('img')

            var reader = new FileReader();
            reader.onload = function() {
                img.src = this.result
            }
            $image = reader.readAsDataURL(selectedFile);


            if (img.src) {
                const editImage = document.getElementById('edit-image');
                editImage.classList.remove('d-none');
            }
        }
    </script>
@endpush
