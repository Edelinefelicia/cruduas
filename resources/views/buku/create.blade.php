{{-- @extends('buku.layout.layout') --}}
{{-- @extends('buku.layout.mainlayouttemp') --}}
@extends('auth.layouts')
{{-- @section('content') --}}
@section('content')
    <div class="container">
        <h4> Tambah Buku </h4>
        <form method="post" action="{{ route('buku.store') }}" enctype="multipart/form-data">
            @csrf
            <div id="thumbInputs">
                Thumbnail
                <input type="file" name="thumbnail" id="thumbnail" class="form-control my-2" onchange="previewImage1(this)">
                <img class="h-full w-full rounded-full object-cover object-center img-fluid" id="preview"
                    alt="Current Thumbnail" class="mt-2" width="150">
                <div class="col-3 mb-3">
                    <div class="gallery_items column">
                        <button type="button" id="deleteButton" class="btn btn-danger mt-2" style="display: none;"
                            onclick="deleteImage()">Delete Image</button>
                    </div>
                </div>
            </div>
            <div>Judul <input type="text" name="judul" class=" form-control"></div>
            <div>Penulis <input type="text" name="penulis" class=" form-control"></div>
            <div>Harga <input type="text" name="harga" class=" form-control"></div>
            <div>Diskon<input type="number" min="0" max="1"step=".01" name="Diskon"
                    class="form-control my-2" placeholder="tuliskan diskon dalam desimal">
            </div>
            <div>Tanggal Terbit <input type="date" class="date form-control" placeholder="yyyy/mm/dd" name="tgl_terbit">
            </div>
            <div id="galleryInputs">
                Gallery
                <div id="galleryInputs">
                    <button type="button" onclick="addNewInput()" class=" form-control my-2">Add Image</button>
                </div>
                <div id="imagePreviews"></div> <!-- To display image previews -->

            </div>


            {{-- @dd( ) --}}
            <!-- Hidden input to store IDs of images to delete -->
            <input type="hidden" name="delete_images" id="delete_images" value="">
            <button type="submit">Simpan</button>
            <a href="{{ '/buku' }}">Kembali</a>
        </form>
        @if (count($errors) > 0)
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
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    preview.src = reader.result;
                    deleteButton.style.display = 'inline-block';
                }
                reader.readAsDataURL(file);
            }
        });

        function deleteImage() {
            preview.src = ''; // Clear the image source
            fileInput.value = ''; // Reset the file input
            deleteButton.style.display = 'none';
        }
    </script>


    <script>
        // Function to add a new file input field when the button is clicked
        function addNewInput() {
            // Create a new file input element
            var newInput = document.createElement('input');

            // Set the attributes for the new input field
            newInput.type = 'file';
            newInput.name = 'gallery[]'; // Make sure it's an array for multiple files
            newInput.accept = 'image/*'; // Only allow image files
            newInput.multiple = true; // Allow multiple files to be selected
            newInput.classList.add('form-control', 'my-2'); // Add the class for styling

            // Add an event listener to handle image preview
            newInput.addEventListener('change', function(event) {
                previewImage(event.target); // Call function to preview selected image
            });

            // Append the new input field to the galleryInputs div
            document.getElementById('galleryInputs').appendChild(newInput);
        }

        // Function to preview the selected image(s)
        // Function to preview the selected image(s)
        function previewImage(input) {
            const fileList = input.files;
            const previewContainer = document.getElementById('imagePreviews');

            // Loop through each selected file and display its preview
            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];

                // Only proceed if the file is an image
                if (file && file.type.startsWith('image/')) {

                    const reader = new FileReader();

                    reader.onload = function(event) {
                        // Create a container for the image and the delete button
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

                        // Add an event listener to delete the image preview
                        deleteButton.addEventListener('click', function() {
                            previewContainer.removeChild(imageContainer);
                            input.value = '';
                        });

                        var input = document.createElement("input");
                        input.type = "text";
                        input.name = "keterangan";
                        input.value = input.value;
                        input.placeholder = "beri keterangan";
                        input.className = "form-control my-2";

                        // Append the image and delete button to the container
                        imageContainer.appendChild(img);
                        imageContainer.appendChild(deleteButton);
                        imageContainer.appendChild(input);
                        previewContainer.appendChild(imageContainer);
                    };

                    reader.readAsDataURL(file); // Read the image as a data URL
                }
            }
        }
    </script>


@endsection
