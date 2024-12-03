<?php

namespace App\Http\Controllers;

// require './vendor/autoload.php';

use App\Models\Bookmarks;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use App\Models\Buku;
use App\Models\Gallery;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function showdetail(string $id)
    {
        //
            // dd($id);
            $query = Buku::with(["reviews","galleries"])->where('id','=',$id);
            $book = $query->get()->first();
            // dd($book);
            return view('buku.detail', compact('book'));
    }
    public function __construct(){
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // dd(10*10);
        // $data_buku = Buku::all();
        $bookmarks = Bookmarks::where('user_id', auth()->id())
        ->with('book')
        ->filter(['kata' => request('kata')]) // Mengambil informasi buku yang dibookmark
        ->limit('5')
        ->get();
        // dd($bookmarks);
        $batas = 5;
        $jumlah_buku = Buku::count();
        $data_buku = Buku::orderBy('id','desc')->paginate($batas);
        $no = $batas*($data_buku->currentPage() - 1);
        // dd($data_buku);
        return view('buku.index', compact('data_buku', 'no','jumlah_buku','bookmarks'));
        // return view('buku.index', compact('data_buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $this->validate($request,[
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'keterangan' => 'nullable|string',
            'diskon' => 'nullable',
        ]);
        $buku = new Buku();
        if($request->hasFile('thumbnail')){

            $filenameWithExt = $request->file('thumbnail')->getClientOriginalName();
            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName,'public');



        $manager = new ImageManager(new Driver());

        // create new image instance with 800 x 600 (4:3)
        $image = $manager->read('storage/'. $filePath);


        // scale to 120 x 100 pixel
        $image->scale(200, 350);
        $image->save();

        $buku->filename = $fileName;
        $buku->filepath = 'storage/'.$filePath;

        }
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga_asli = $request->harga;
        $buku->diskon = $request->Diskon;

        $buku->harga_setelah_potongan = ($request->harga)-(($request->Diskon)*($request->harga));

        $buku->tgl_terbit = $request->tgl_terbit;

        $buku->save();



        if ($request->file('gallery')) {
            // dd($request);
            foreach ($request->file('gallery') as $file) {
                $filenameWithExt1 = $file->getClientOriginalName();
                // Generate a unique file name
                $fileName2 = time().'_'.$file->getClientOriginalName();

                // Store the file in the 'uploads' directory within the 'public' disk
                $filePaths = $file->storeAs('uploads', $fileName2, 'public');

                // dd($buku->id);
                Gallery::create([
                    'nama_galeri'=> $filenameWithExt1,
                    'foto' => 'storage/'.$filePaths,
                    'buku_id'=> $buku->id,
                    'keterangan' => $request->keterangan
                ]);
            }
        }



        return redirect('/buku')->with('pesansimpan', 'data buku berhasil ditambahkan');

    }

    public function bulkDelete( string $id)
{
    $gallery = Gallery::findOrFail($id);

    // Hapus data dari database
    $gallery->delete();

    return redirect()->back()->with('success', 'Image deleted successfully.');

}

// public function thumbnailDelete( string $id)
// {

//         $buku = Buku::findOrFail($id);

//         // Cek apakah file path ada dan file fisik masih ada di server
//         if ($buku->filepath && file_exists(public_path($buku->filepath))) {
//             unlink(public_path($buku->filepath)); // Menghapus file fisik dari server
//             $buku->update(['filepath' => null]); // Menghapus path dari database
//         }

//         return redirect()->back()->with('success', 'Thumbnail berhasil dihapus');



// }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // dd($id);
        $buku = Buku::with('galleries')->find($id);
        // $galleries = $buku->galleries->get();
        // dd($buku);
        // dd($buku);
        return view('buku.edit',compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $this->validate($request,[
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'keterangan' => 'nullable|string',
            'diskon' => 'nullable',
        ]);
        $buku = Buku::find($id);



        if($request->hasFile('thumbnail')){

            $filenameWithExt = $request->file('thumbnail')->getClientOriginalName();
            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName,'public');



        $manager = new ImageManager(new Driver());

        // create new image instance with 800 x 600 (4:3)
        $image = $manager->read('storage/'. $filePath);


        // scale to 120 x 100 pixel
        $image->scale(150, 250);
        $image->save();

        $buku->filename = $fileName;
        $buku->filepath = 'storage/'.$filePath;

        }
        // dd($request->thumbnail_deleted );

        if ($request->has('thumbnail_deleted') && $request->thumbnail_deleted == '1') {
            // Jika gambar dihapus, hapus file dari server
            if ($buku->filepath && file_exists(public_path($buku->filepath))) {
                unlink(public_path($buku->filepath)); // Hapus file dari server
            }

            // Reset nilai filepath di database
            $buku->filepath = null;
            $buku->filename = null;
        }

        if ($request->file('gallery')) {
            // dd($request);
            foreach ($request->file('gallery') as $file) {
                $filenameWithExt1 = $file->getClientOriginalName();
                // Generate a unique file name
                $fileName2 = time().'_'.$file->getClientOriginalName();

                // Store the file in the 'uploads' directory within the 'public' disk
                $filePaths = $file->storeAs('uploads', $fileName2, 'public');

                Gallery::create([
                    'nama_galeri'=> $filenameWithExt1,
                    'foto' => 'storage/'.$filePaths,
                    'buku_id'=> $id,
                    'keterangan' => $request->keterangan
                ]);
            }
        }
        if ($request->has('delete_images')) {
            $deleteImageIds = explode(',', $request->delete_images); // Convert comma-separated string to an array

            foreach ($deleteImageIds as $imageId) {
                $gallery = Gallery::find($imageId);

                // Optionally, delete the image file from storage
                if ($gallery && file_exists(public_path($gallery->foto))) {
                    unlink(public_path($gallery->foto)); // Delete the image file
                }

                // Delete the gallery record
                if ($gallery) {
                    $gallery->delete();
                }
            }
        }


        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga_asli = $request->harga;
        $buku->diskon = $request->Diskon;
        // dd();
        $buku->harga_setelah_potongan = ($request->harga)-(($request->Diskon)*($request->harga));
        $buku->tgl_terbit = $request->tgl_terbit;


        $buku->save();
        return redirect('/buku')->with('pesanupdate', 'data buku berhasil diupdate');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $buku = Buku::find($id);
        // dd($buku);
        $buku->delete();
        return redirect('/buku')->with('pesanhapus', 'data buku berhasil dihapus');

    }

    // soal ketiga tugas praktikkum step 2 & 3
    public function search(Request $request)
    {
        // dd($request->all());
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%".$cari."%")->orwhere('penulis','like',"%".$cari."%")->paginate($batas);
        $jumlah_buku = $data_buku->count();
        $no = $batas*($data_buku->currentPage() - 1);
        return view('buku.search', compact('jumlah_buku','data_buku', 'no','cari'));
    }
}
