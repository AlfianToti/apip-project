@extends('masteradmin')

@section('content')
    <div class="container mt-5 mb-5 px-2">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <h1 class="mb-4">Daftar Barang</h1>
            <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3" style="background-color: #00a2ea; color: white;">Tambah Barang</a>
            
            <table class="table table-bordered table-striped">
                <thead style="background-color: #00a2ea; color: white;">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->status ? 'Tersedia' : 'Tidak Tersedia' }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $barang->kode_barang) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('barang.destroy', $barang->kode_barang) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
