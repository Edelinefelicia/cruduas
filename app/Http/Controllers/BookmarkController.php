<?php

namespace App\Http\Controllers;

use App\Models\Bookmarks;
use App\Models\Buku;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    //
    public function store(Request $request, $bookId)
    {
        // Validasi: Pastikan buku ada dan pengguna sudah login
        $book = Buku::findOrFail($bookId);

        // Cek apakah buku sudah dibookmark oleh pengguna
        $existingBookmark = Bookmarks::where('user_id', auth()->id())
                                    ->where('book_id', $bookId)
                                    ->first();

        if ($existingBookmark) {
            return redirect(to:  '/buku')->with('pesanbookmarksudah', 'data buku sudah ditambahkan ke bookmark');

        }

        // Menambahkan bookmark baru
        $bookmark = Bookmarks::create([
            'user_id' => auth()->id(),
            'book_id' => $bookId,
        ]);

        return redirect(to:  '/buku')->with('pesanbookmark', 'data buku berhasil ditambahkan ke bookmark');
    }

    public function destroy($bookId)
    {
        // Mencari bookmark yang ingin dihapus
        $bookmark = Bookmarks::where('user_id', auth()->id())
                            ->where('book_id', $bookId)
                            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return redirect(to:  '/buku')->with('pesanhapusbookmark', 'data buku terhapus ke bookmark');
        }

        return redirect(to:  '/buku')->with('pesanhapusbookmark', 'data buku tidak ada');
    }

    // public function getBookmarks()
    // {
    //     // dd(request('kata'));
    //     // Mengambil semua bookmark pengguna
    //     $bookmarks = Bookmarks::where('user_id', auth()->id())
    //                          ->with('book')
    //                          ->filter(['kata' => request('kata')]) // Mengambil informasi buku yang dibookmark
    //                          ->get();
    //                         //  dd($bookmarks);
    //     return view('buku.index',compact('bookmarks'));
    //     // return response()->json($bookmarks);
    // }
}
