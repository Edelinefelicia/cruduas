@extends('auth.layouts')

@section('content')
    <div class="container">
        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ route('dashboard') }}" class="btn btn-warning mb-5">Kembali ke Halaman Utama</a>
        </div>
        <h3 class="section-title">Daftar Reviewer</h3>
        <div class="tag-list">
            <ul>
                <!-- Show All Reviews -->
                <li class="tag-item">
                    <a href="{{ route('reviews.reviewer', ['search' => 'all']) }}" class="tag-link">Semua Review</a>
                </li>
                @foreach ($reviewers as $reviewer)
                    <li class="tag-item">
                        <a href="{{ route('reviews.reviewer', ['search' => $reviewer->name]) }}"
                            class="tag-link">{{ $reviewer->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <h3 class="section-title">Daftar Review</h3>
        <div class="reviews">
            @foreach ($reviews as $review)
                <div class="review-card">
                    <h4 class="review-title">{{ $review->book->judul }} - <span
                            class="reviewer-name">{{ $review->user->name }}</span></h4>
                    <p class="review-content">{{ $review->review_content }}</p>
                    <div class="review-tags">
                        <strong>Tags:</strong>
                        @foreach ($review->tags as $tag)
                            <span class="review-tag">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Add Styling -->
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        /* Tag List Styles */
        .tag-list ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tag-item {
            margin: 0;
        }

        .tag-link {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 20px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .tag-link:hover {
            background-color: #0056b3;
        }

        /* Review Card Styles */
        .reviews .review-card {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .review-title {
            font-size: 1.5rem;
            color: #333;
        }

        .reviewer-name {
            font-style: italic;
            color: #555;
        }

        .review-content {
            font-size: 1rem;
            color: #444;
            margin-top: 10px;
        }

        .review-tags {
            margin-top: 15px;
        }

        .review-tag {
            background-color: #e2e2e2;
            color: #333;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 5px;
            font-size: 0.9rem;
        }
    </style>
@endsection
