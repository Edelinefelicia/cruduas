<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class BookReviewController extends Controller
{
    //
    public function show()
    {
        // Pastikan hanya internal reviewer yang bisa mengakses
        if (auth()->user()->level !== 'internal_reviewer' && auth()->user()->level !== 'admin') {
            abort(403, 'Unauthorized action.');
        }


        // Ambil semua buku untuk dropdown
        $books = Buku::all();

        // Tampilkan view dengan daftar buku
        return view('review.form', compact('books'));
    }

    public function submit(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'review_content' => 'required|string',
        'tags' => 'required|string', // JSON string dari input tags
    ]);

    $tags = json_decode($request->tags, true);

    $review = Review::create([
        'book_id' => $request->book_id,
        'reviewer_id' => auth()->id(),
        'review_content' => $request->review_content,
        'review_date' => now(),
    ]);

    // Simpan atau buat tag baru
    $tagIds = [];
    foreach ($tags as $tagName) {
        $tag = Tag::firstOrCreate(['name' => $tagName]);
        $tagIds[] = $tag->id;
    }

    // Hubungkan review dengan tag
    $review->tags()->sync($tagIds);

    return redirect()->route('review.form')->with('success', 'Review berhasil disimpan!');
}

    public function reviewsByReviewer(Request $request)
    {
        $search = $request->input('search');

        if ($search === 'all') {
            // Fetch all reviews if "all" is selected
            $reviews = Review::with('book', 'user', 'tags')->get();
        } else {
            // Fetch reviews by a specific reviewer
            $reviewer = User::where('name', 'like', "%{$search}%")->first();
            if ($reviewer) {
                $reviews = $reviewer->reviews()->with('book','tags')->get();
            } else {
                $reviews = collect(); // Return an empty collection if reviewer not found
            }
        }

        // Get all available reviewers for the search bar
        $reviewers = User::all();

        return view('review.reviewer', compact('reviews', 'reviewers'));
    }

    public function reviewsByTag(Request $request)
    {
        // Ambil semua tag
        $search = $request->input('search');

    if ($search === 'all') {
        // Fetch all reviews if the "all" tag is clicked
        $reviews = Review::with('book', 'user', 'tags')->get();
    } else {
        // Fetch reviews filtered by the selected tag
        $tag = Tag::where('name', $search)->first();
        if ($tag) {
            $reviews = $tag->reviews()->with('book', 'user', 'tags')->get();
        } else {
            $reviews = collect(); // Return an empty collection if tag not found
        }
    }

    // Get all available tags for the sidebar
    $tags = Tag::all();

    return view('review.tag', compact('reviews', 'tags'));
    }



        // Redirect ke halaman formulir dengan pesan sukses
}
