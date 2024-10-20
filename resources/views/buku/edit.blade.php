{{-- @extends('buku.layout.layout') --}}
@extends('buku.layout.mainlayouttemp')
{{-- @section('content') --}}
@section('content2')
    <div class="container">
        <h4> Edit Buku </h4>
        <form method="post" action="{{ route('buku.update', $buku->id) }}">
            @csrf
            @method('PUT')
            <div>Judul<input type="text" name="judul" value="{{ $buku->judul }}" class="form-control"></div>
            <div>Penulis<input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control"></div>
            <div>Harga<input type="text" name="harga" value="{{ $buku->harga }}" class="form-control"></div>
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
