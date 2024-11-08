{{-- @extends('buku.layout.layout') --}}
{{-- @extends('buku.layout.mainlayouttemp') --}}
@extends('auth.layouts')
{{-- @section('content') --}}
@section('content')
    <div class="container">
    <h4> Edit Buku </h4>


        <form method="post" action="{{ route('buku.update', $buku->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- @dd($buku->filepath) --}}
            <div id="thumbInputs">
                Thumbnail
                <input type="file" name="thumbnail" id="thumbnail" class="form-control my-2" onchange="previewImage1(this)">
                <img src="{{ asset($buku->filepath) }}" class="h-full w-full rounded-full object-cover object-center img-fluid" id="preview" alt="Current Thumbnail" class="mt-2" width="150">
                <div class="col-3 mb-3">
                    <div class="gallery_items column">
                        <button type="button" id="deleteButton1"  class="btn btn-danger mt-2 delete-image1" onclick="deleteImage()">Delete Image</button>
                    </div>
                </div>
                <input type="hidden" id="thumbnail_deleted" name="thumbnail_deleted" value="0">
            </div>


            <div>Judul<input type="text" name="judul" value="{{ $buku->judul }}" class="form-control my-2"></div>
            <div>Penulis<input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control my-2"></div>
            <div>Harga<input type="text" name="harga" value="{{ $buku->harga }}" class="form-control my-2"></div>
            <div id="galleryInputs">
                Gallery
                <button type="button" onclick="addNewInput()" class="form-control my-2">Add Image</button>
                <div id="imagePreviews"></div> <!-- Untuk menampilkan pratinjau gambar -->
            </div>
            <div class="gallery_items">
                @if($buku->galleries->isEmpty())
                    <p>No images uploaded.</p>
                @else
                    <div class="row">
                        @foreach ($buku->galleries as $gallery)
                            <div class="col-3 mb-3" id="gallery-item-{{ $gallery->id }}">
                                <div class="gallery_items column">
                                    <img class="h-full w-full rounded-full object-cover object-center img-fluid" src="{{ asset($gallery->foto) }}" alt="" id="image-preview-{{ $gallery->id }}"/>
                                    <!-- Button to delete the image -->
                                     <!-- Checkbox to mark image for deletion -->
                                     <button type="button" class="btn btn-danger mt-2 delete-image" data-id="{{ $gallery->id }}">
                                        Delete Image
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            {{-- @dd( ) --}}
            <!-- Hidden input to store IDs of images to delete -->
            <input type="hidden" name="delete_images" id="delete_images" value="">
            <div>
                Tanggal Terbit
                <input type="date" class="date form-control my-2" value="{{ $buku->tgl_terbit->format('Y-m-d') }}" placeholder="yyyy-mm-dd" name="tgl_terbit">
            </div>
                <button type="submit" class="my-2">Simpan</button>
                <a href="{{ '/buku' }}" class="my-2">Kembali</a>
        </form>
        @if(count($errors)>0)
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </div>


<script>

    const fileInput = document.getElementById('thumbnail');
    const preview = document.getElementById('preview');
    const deleteButton = document.getElementById('deleteButton');

    // Preview for thumbnail
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function () {
                preview.src = reader.result;
                deleteButton.style.display = 'inline-block';
            }
            reader.readAsDataURL(file);
        }
    });
    function deleteImage() {
        preview.src = ''; // Clear the image source
        fileInput.value = ''; // Reset the file input
        const bukuId = {{ $buku->id }}; // Mengambil ID buku dari Laravel variable
        const deleteButton = document.getElementById('deleteButton1');
        const imagePreview = document.getElementById('preview');

        document.getElementById('thumbnail_deleted').value = '1';

        // Menyembunyikan gambar dan tombol delete
        imagePreview.style.display = 'none';
        deleteButton.style.display = 'none';
        // Assuming you have a delete button


        // Menyimpan ID buku dan status thumbnail di form
        // document.getElementById('thumbnail_deleted').value = "1";
        // document.querySelectorAll('.delete-image1').forEach(button => {
        // button.addEventListener('click', function() {
        // const imageId = this.getAttribute('data-id'); // Get image ID from data-id attribute
        // let deleteImagesInput = document.getElementById('delete_images');

        // // Get current value of the hidden input (it stores the IDs of the images to delete)
        // let deleteImagesValue = deleteImagesInput.value;

        // // Add the current image ID to the value (if not already added)
        // if (!deleteImagesValue.includes(imageId)) {
        //     deleteImagesValue = deleteImagesValue ? deleteImagesValue + ',' + imageId : imageId;
        //     deleteImagesInput.value = deleteImagesValue;
        // }

        // // Hide the image preview and the delete button from the UI
        // const imagePreview = document.getElementById('image-preview-' + imageId);
        // const deleteButton1 = document.querySelector('[data-id="' + imageId + '"]');

        // if (imagePreview) {
        //     imagePreview.style.display = 'none'; // Hide the image preview
        // }
        // if (deleteButton) {
        //     deleteButto1n.style.display = 'none'; // Hide the delete button
        // }

        // // Optionally, show the user which images are marked for deletion
        // console.log('Images marked for deletion: ', deleteImagesInput.value);
        //     });
        // });

}
</script>

    <script>
        // Fungsi untuk menambahkan input file baru
        function addNewInput() {
            var newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'gallery[]';
            newInput.accept = 'image/*';
            newInput.classList.add('form-control', 'my-2');

            newInput.addEventListener('change', function(event) {
                previewImage(event.target);
            });

            document.getElementById('galleryInputs').appendChild(newInput);
        }

        // Fungsi untuk menampilkan pratinjau gambar
        function previewImage(input) {
            const fileList = input.files;
            const previewContainer = document.getElementById('imagePreviews');

            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        // Membuat elemen container untuk gambar dan tombol delete
                        const imageContainer = document.createElement('div');
                        imageContainer.classList.add('d-inline-block', 'm-2', 'text-center');
                    imageContainer.style.width = '200px';

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.classList.add('img-fluid', 'rounded');
                    img.style.width = '100%';

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.classList.add('btn', 'btn-danger', 'mt-2');
                    deleteButton.style.fontSize = '15px';
                    deleteButton.style.padding = '5px 10px';

                        // Menambahkan event listener untuk menghapus pratinjau gambar
                        deleteButton.addEventListener('click', function() {
                            previewContainer.removeChild(imageContainer);
                            input.value = '';
                        });

                        imageContainer.appendChild(img);
                        imageContainer.appendChild(deleteButton);
                        previewContainer.appendChild(imageContainer);
                    };

                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
    <!-- delete preview -->
    <script>
        document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
        const imageId = this.getAttribute('data-id'); // Get image ID from data-id attribute
        let deleteImagesInput = document.getElementById('delete_images');

        // Get current value of the hidden input (it stores the IDs of the images to delete)
        let deleteImagesValue = deleteImagesInput.value;

        // Add the current image ID to the value (if not already added)
        if (!deleteImagesValue.includes(imageId)) {
            deleteImagesValue = deleteImagesValue ? deleteImagesValue + ',' + imageId : imageId;
            deleteImagesInput.value = deleteImagesValue;
        }

        // Hide the image preview and the delete button from the UI
        const imagePreview = document.getElementById('image-preview-' + imageId);
        const deleteButton = document.querySelector('[data-id="' + imageId + '"]');

        if (imagePreview) {
            imagePreview.style.display = 'none'; // Hide the image preview
        }
        if (deleteButton) {
            deleteButton.style.display = 'none'; // Hide the delete button
        }

        // Optionally, show the user which images are marked for deletion
        console.log('Images marked for deletion: ', deleteImagesInput.value);
            });
        });

    </script>


    @endsection
