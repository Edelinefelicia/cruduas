<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data_buku = Buku::all();
        return view('buku.index', compact('data_buku'));
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
        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect('/buku');

    }

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
        $buku = Buku::find($id);
        // dd($buku);
        return view('buku.edit',compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $buku = Buku::find($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect('/buku');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/buku');
    }
}
