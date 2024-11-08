@extends('auth.layouts')
@php
    use Illuminate\Support\Facades\Session;
@endphp

@section('content')
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
    <div class="card-header">
        @if (Auth::check() && Auth::user()->level =='admin')
            <a href="{{ route('buku.create') }}" class="btn btn-primary float-end" style=" display:inline; margin-top: 10px; margin-bottom:10px ; float: right;margin-right:10px;">Tambah Buku</a>
        @endif
            {{-- soal ketiga tugas praktikkum step 4 --}}
        <form action="{{ route('buku.search') }}" method="get">
            @csrf
            <input type="text" name="kata" class="form-control" placeholder="Cari..." style="display:inline; width: 30%; display:inline; margin-top: 10px; margin-bottom:10px ; float: right;height:38px; margin-right:10px">
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
                            <th>Gambar</th>
                            @if (Auth::check() && Auth::user()->level =='admin')
                                <th>Aksi</th>
                            @endif
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

                                @if($buku->filepath)
                                    <td>
                                        <div class="relative h-10 w-10">
                                            <img class="h-full w-full rounded-full object-cover object-center" src="{{  asset($buku->filepath)}}" alt=""/>
                                        </div>
                                    </td>
                                @else
                                <td>no found</td>
                                @endif

                                @if (Auth::check()&&Auth::user()->level =='admin')
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
                                @endif
                            </tr>
                        @endforeach


                    </tbody>
                </table>
                <div>{{ $data_buku->links('pagination::bootstrap-5') }}</div>
                <div><strong>Jumlah Buku: {{ $jumlah_buku }}</strong></div>
            </div>
@endsection
