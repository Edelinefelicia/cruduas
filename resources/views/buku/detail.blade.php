@extends('auth.layouts')


@section('content')

    {{-- <p>{{ $book->reviews->reviewText }}</p> --}}
    <div class="container">
        @php
            $counter = 0;
        @endphp
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cover Buku -->
            <div class="flex-shrink-0">
                <img src="{{ asset($book->filepath) }}" alt="Cover Buku" class="w-full lg:w-80 rounded shadow">
            </div>
            <!-- Informasi Buku -->
            <div class="flex-1">
                <h1 class="text-3xl font-bold">{{ $book->judul }}</h1>
                <p class="text-gray-600 text-lg mb-4">by {{ $book->penulis }}</p>
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span
                        class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">{{ $book->harga }}</span>
                </div>

            </div>
            <div class="flex-shrink-0">
                Gallery
                @if ($book->galleries->isEmpty())
                    <p>No images uploaded.</p>
                @else
                    <div class="row">
                        @foreach ($book->galleries as $gallery)
                            <div class="col-3 mb-3" id="gallery-item-{{ $gallery->id }}">
                                <div class="gallery_items column">
                                    <img class="h-full w-full rounded-full object-cover object-center img-fluid"
                                        src="{{ asset($gallery->foto) }}" alt=""
                                        id="image-preview-{{ $gallery->id }}" />
                                    <!-- Button to delete the image -->
                                    <!-- Checkbox to mark image for deletion -->

                                    <div>Keterangan<p class="text-lg font-bold"
                                            style="font-size: 20px; font-weight: bold;;">
                                            {{ $gallery->keterangan }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Reviews Section -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-4">Reviews</h2>
                @if ($book->reviews->isEmpty())
                    <p class="text-gray-600">No reviews yet. Be the first to review this book!</p>
                @else
                    <ul class="space-y-6">
                        @foreach ($book->reviews as $review)
                            {{-- @php
                                    $counter++;
                                    if ($counter === 3) {
                                        dd($review);
                                    }
                                @endphp --}}
                            <li class="p-4 border rounded-lg shadow-sm">
                                <div class="flex justify-between mb-2">

                                    <p class="font-bold">{{ $review->user->name }}</p>
                                </div>
                                <p class="text-gray-800">{{ $review->reviewText }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
