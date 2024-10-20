{{-- soal ketiga tugas praktikkum step 5 --}}
{{-- @extends('buku.layout.layout') --}}
@extends('buku.layout.mainlayouttemp')
@php
    use Illuminate\Support\Facades\Session;
@endphp

{{-- @section('content') --}}
@section('content2')
        {{-- soal ketiga tugas praktikkum step 6 --}}
        @if(count($data_buku))
        <div class="alert alert-success" >Ditemukan <strong>{{ count($data_buku) }}</strong> data dengan kata: <strong>{{ $cari }}</strong></div>
        {{-- soal ketiga tugas praktikkum step 7 --}}
        @else
        <div class="alert alert-waring" style=" display:inline-block; margin:0px;color:black;"><h4>Data {{ $cari }} tidak ditemukan</div>
        <a href="/buku" class="btn btn-warning" >Kembali</a></div>
        @endif
        <div class="card-header">
        <a href="{{ route('buku.create') }}" class="btn btn-primary" style=" margin-top: 10px; margin-bottom:10px ; float: right;margin-right:10px;">Tambah Buku</a>
            <form action="{{ route('buku.search') }}" method="get" style=" display:inline; margin:0px;">
                @csrf
                <input type="text" name="kata" class="form-control" placeholder="Cari..." style="width: 30%; display:inline-block; margin-top: 10px; margin-bottom:10px ; float: right;height:38px; margin-right:10px;">
            </form>
        </div>
        <div class="card-body">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Harga</th>
                            <th>Tanggal Terbit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_buku as $index => $buku)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $buku->judul }}</td>
                                <td>{{ $buku->penulis }}</td>
                                <td>{{ "Rp.".number_format($buku->harga,0,',','.') }}</td>
                                <td>{{ $buku->tgl_terbit->format('d/m/Y')}}</td>
                                <td>
                                    <form action="{{ route ('buku.destroy', $buku->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin Mau di Hapus?')" type="submit"
                                        class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning float-end">Edit</a>
                                </td>
                            </tr>
                        @endforeach

                        {{-- soal pertama tugas praktikkum --}}
                        @if(Session::has('pesansimpan'))
                        <div class="alert alert-success">{{ Session::get('pesansimpan') }}</div>
                        @endif
                        @if(Session::has('pesanhapus'))
                        <div class="alert alert-success">{{ Session::get('pesanhapus') }}</div>
                        @endif
                        @if(Session::has('pesanupdate'))
                        <div class="alert alert-success">{{ Session::get('pesanupdate') }}</div>
                        @endif

                    </tbody>
                </table>
                <div>{{ $data_buku->links('pagination::bootstrap-5') }}</div>
                <div><strong>Jumlah Buku: {{ $jumlah_buku }}</strong></div>
            </div>
@endsection
