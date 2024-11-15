<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
//import Resource "PostResource"

class BookApiContoller extends Controller
{
    //
    public function index() {
        $books = Buku::latest()->paginate(5);
        return new BookResource(true, 'List Data Buku', $books);
    }
    public function store(Request $request){
         // dd($request->all());

         $buku = new Buku;
         $rules = [
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
         ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'messgae' =>'Gagal memasukkan data',
                'data' => $validator->errors()
            ]);
        }
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;

        $buku->save();
        return response()->json([
            'status' =>true,
            'message' => 'Sukses menerima data'
        ]);

    }
}
