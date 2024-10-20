{{-- @extends('buku.layout.layout') --}}
@extends('buku.layout.mainlayouttemp')
{{-- @section('content') --}}
@section('content2')
    <div class="container">
        <h4> Tambah Buku </h4>
        <form method="post" action="{{ route('buku.store') }}">
            @csrf
            <div>Judul <input type="text" name="judul" class=" form-control"></div>
            <div>Penulis <input type="text" name="penulis" class=" form-control"></div>
            <div>Harga <input type="text" name="harga" class=" form-control"></div>
            <div>Tanggal Terbit <input type="date" class="date form-control" placeholder="yyyy/mm/dd" name="tgl_terbit"></div>
            <button type="submit">Simpan</button>
            <a href="{{ '/buku' }}">Kembali</a>
        </form>
        @if(count($errors)>0)
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </div>
    @endsection

