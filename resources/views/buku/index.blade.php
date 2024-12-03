@extends('auth.layouts')
@php
    use Illuminate\Support\Facades\Session;
@endphp

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <div class="container">
        @if (Session::has('pesanhapusbookmark'))
            <div class="alert alert-success">{{ Session::get('pesanhapusbookmark') }}</div>
        @endif
        <h1>THe Editorial Pick Books</h1>
        <div class="card-header">
            {{-- soal ketiga tugas praktikkum step 4 --}}
            <form action="{{ route('books.getbookmark') }}">
                @csrf
                <input type="text" name="kata" class="form-control" placeholder="Cari..." value="{{ request('kata') }}"
                    style="display:block; width: 30%;  margin-top: 10px; margin-bottom:10px ; height:38px; margin-right:10px">
            </form>
        </div>

        @if ($bookmarks->isEmpty())
            <p>You have no bookmarked books.</p>
            {{-- @elseif (!$bookmarks->count())
        <p>You have no bookmarked books.1</p> --}}
        @else
            <ul class="list-group">
                @foreach ($bookmarks as $bookmark)
                    {{-- @php
                        dd($bookmark->book->id);
                    @endphp --}}
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            @if ($bookmark->book->filepath)
                                <td>
                                    <div class="relative h-10 w-10">
                                        <img class="h-full w-full rounded-full object-cover object-center"
                                            src="{{ asset($bookmark->book->filepath) }}" alt="" />
                                    </div>
                                </td>
                            @else
                                <td>no found thumbnail</td>
                            @endif
                            <br>
                            <strong>{{ $bookmark->book->judul }}</strong>
                            by
                            {{ $bookmark->book->penulis ?? 'Unknown Author' }}
                        </div>
                        @if (Auth::check() && Auth::user()->level == 'admin')
                            <form action="{{ route('books.removeBookmark', $bookmark->book->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    {{-- soal pertama tugas praktikkum --}}
    @if (Session::has('pesansimpan'))
        <div class="alert alert-success">{{ Session::get('pesansimpan') }}</div>
    @endif
    @if (Session::has('pesanhapus'))
        <div class="alert alert-success">{{ Session::get('pesanhapus') }}</div>
    @endif
    @if (Session::has('pesanupdate'))
        <div class="alert alert-success">{{ Session::get('pesanupdate') }}</div>
    @endif
    <div class="card-header">
        @if (Auth::check() && Auth::user()->level == 'admin')
            <a href="{{ route('buku.create') }}" class="btn btn-primary float-end"
                style=" display:inline; margin-top: 10px; margin-bottom:10px ; float: right;margin-right:10px;">Tambah
                Buku</a>
        @endif
        @if (Auth::check() && (Auth::user()->level == 'internal_reviewer' || Auth::user()->level == 'admin'))
            <a href="{{ route('review.form') }}" class="btn btn-primary float-end"
                style=" display:inline; margin-top: 10px; margin-bottom:10px ; float: right;margin-right:10px;">Review
                Buku</a>
        @endif
        <a href="{{ route('reviews.reviewer') }}" class="btn btn-primary float-end"
            style=" display:inline; margin-top: 10px; margin-bottom:10px ; float: right;margin-right:10px;">Review
            Berdasarkan Reviewer</a>
        <a href="{{ route('reviews.tag') }}" class="btn btn-primary float-end"
            style=" display:inline; margin-top: 10px; margin-bottom:10px ; float: right;margin-right:10px;">Review
            Berdasarkan Tag</a>
        {{-- soal ketiga tugas praktikkum step 4 --}}
        <form action="{{ route('buku.search') }}" method="get">
            @csrf
            <input type="text" name="kata" class="form-control" placeholder="Cari..."
                style="display:inline; width: 30%; display:inline; margin-top: 10px; margin-bottom:10px ; float: right;height:38px; margin-right:10px">
        </form>

    </div>
    <div class="card-body">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Buku</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Tanggal Terbit</th>
                    <th>Gambar</th>
                    @if (Auth::check() && Auth::user()->level == 'admin')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data_buku as $index => $buku)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="{{ route('buku.detail', $buku->id) }}"> {{ $buku->judul }}</a></td>
                        <td>{{ $buku->penulis }}</td>
                        <td>

                            <del style="color:red;">{{ 'Rp.' . number_format($buku->harga_asli, 0, ',', '.') }}</del>

                            <span class="badge badge-pill badge-success"
                                style="color: white;">{{ $buku->diskon * 100 . '%' }}</span>
                            <p style="color: green">
                                {{ 'Rp.' . number_format($buku->harga_setelah_potongan, 0, ',', '.') }}</p>

                        </td>
                        <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>


                        @if ($buku->filepath)
                            <td>
                                <div class="relative h-10 w-10">
                                    <img class="h-full w-full rounded-full object-cover object-center"
                                        src="{{ asset($buku->filepath) }}" alt="" />
                                </div>
                            </td>
                        @else
                            <td>no found</td>
                        @endif

                        @if (Auth::check() && Auth::user()->level == 'admin')
                            <td>
                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin Mau di Hapus?')" type="submit"
                                        class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning float-end">Edit</a>
                            </td>
                            <td><!-- Menandai buku sebagai bookmark -->
                                <form action="{{ route('books.bookmark', $buku->id) }}" method="POST">
                                    @csrf
                                    <button type="submit">Editorial Pick</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach


            </tbody>
        </table>
        <div>{{ $data_buku->links('pagination::bootstrap-5') }}</div>
        <div><strong>Jumlah Buku: {{ $jumlah_buku }}</strong></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

@endsection
