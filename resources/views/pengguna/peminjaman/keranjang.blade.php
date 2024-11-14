@extends('masteruser')

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

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h1 class="mb-4">Keranjang Peminjaman Anda</h1>

        <!-- Form untuk Menambahkan Barang ke Keranjang -->
        <form action="{{ route('peminjaman.keranjang.add') }}" method="POST" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="kode_barang">Pilih Barang</label>
                <select name="barang_id" class="form-control">
                    <option value="">Pilih Barang</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="kode_ruang">Pilih Ruangan</label>
                <select name="kode_ruang" id="kode_ruang" class="form-control" required>
                    <option value="" disabled selected>Pilih Ruangan</option>
                    @foreach($ruangs as $ruang)
                        <option value="{{ $ruang->kode_ruang }}">{{ $ruang->nama_ruang }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Tambahkan ke Keranjang</button>
        </form>

        <!-- Tabel Keranjang -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjangItems as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>
                            <form action="{{ route('peminjaman.keranjang.remove', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
