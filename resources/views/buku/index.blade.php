<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>

                <a href="{{ route('buku.create') }}" class="btn btn-primary float-end">Tambah Buku</a>
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
                                <td>{{ "Rp.".number_format($buku->harga,2,',','.') }}</td>
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
                    </tbody>
                </table>
</body>
</html>
