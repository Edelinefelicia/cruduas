@extends('auth.layouts')

@section('content')
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('dashboard') }}" class="btn btn-warning mb-5">Kembali ke Halaman Utama</a>
    </div>

    <div class="container mt-5">
        <div class="card shadow p-4">
            <h1 class="text-center mb-4">Formulir Review Buku</h1>

            <!-- Menampilkan pesan sukses jika ada -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Tombol untuk menampilkan formulir -->
            <div class="text-center mb-4">
                <button id="showFormButton" class="btn btn-primary">Tulis Review</button>
            </div>

            <!-- Formulir Review Buku -->
            <form action="{{ route('review.submit') }}" method="POST" id="reviewForm" class="d-none">
                @csrf

                <div class="mb-3">
                    <label for="book_id" class="form-label">Pilih Buku</label>
                    <select name="book_id" id="book_id" class="form-select" required>
                        <option value="" disabled selected>Pilih buku...</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">{{ $book->judul }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="review_content" class="form-label">Review</label>
                    <textarea name="review_content" id="review_content" class="form-control" rows="4"
                        placeholder="Tulis review Anda..." required></textarea>
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <div id="tags-container" class="form-control p-2">
                        <input type="text" id="tag-input" class="form-control border-0"
                            placeholder="Tambahkan tag lalu tekan Enter">
                        <div id="tags-list" class="d-flex flex-wrap mt-2"></div>
                    </div>
                    <input type="hidden" name="tags" id="tags-hidden-input">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Simpan Review</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Tambahkan Styling Khusus -->
    <style>
        #tags-container {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #tags-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tag-item {
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
        }

        .tag-item span {
            margin-right: 10px;
        }

        .tag-item button {
            background: none;
            border: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        #showFormButton {
            transition: transform 0.2s ease-in-out;
        }

        #showFormButton:hover {
            transform: scale(1.05);
        }
    </style>

    <!-- Tambahkan JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagInput = document.getElementById('tag-input');
            const tagsList = document.getElementById('tags-list');
            const tagsHiddenInput = document.getElementById('tags-hidden-input');
            const form = document.getElementById('reviewForm');
            const showFormButton = document.getElementById('showFormButton');
            let tags = [];

            // Toggle form visibility
            showFormButton.addEventListener('click', function() {
                form.classList.toggle('d-none');
            });

            // Add tag logic
            tagInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const newTag = tagInput.value.trim();
                    if (newTag && !tags.includes(newTag)) {
                        tags.push(newTag);
                        updateTags();
                    }
                    tagInput.value = '';
                }
            });

            function updateTags() {
                tagsList.innerHTML = '';
                tags.forEach((tag, index) => {
                    const tagItem = document.createElement('div');
                    tagItem.className = 'tag-item';
                    tagItem.innerHTML = `
                    <span>${tag}</span>
                    <button type="button" onclick="removeTag(${index})">&times;</button>
                `;
                    tagsList.appendChild(tagItem);
                });
                tagsHiddenInput.value = JSON.stringify(tags);
            }

            window.removeTag = function(index) {
                tags.splice(index, 1);
                updateTags();
            };
        });
    </script>
@endsection
