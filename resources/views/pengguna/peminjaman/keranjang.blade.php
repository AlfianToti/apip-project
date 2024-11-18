@extends('masteruser')

@section('content')
<div class="container">
    <h2>Keranjang Peminjaman Barang</h2>

    <!-- Pesan Sukses/Error -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form untuk Menambahkan Barang ke Keranjang -->
    <div class="mb-4">
        @if($barangTersedia->isEmpty())
            <p>Tidak ada barang yang tersedia untuk ditambahkan ke keranjang.</p>
        @else
            <form action="{{ route('keranjang.store') }}" method="POST">
            @csrf
                <div class="row">
                    <div class="col-md-8">
                        <label for="kode_barang" class="form-label">Pilih Barang</label>
                        <select name="kode_barang" id="kode_barang" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangTersedia as $barang)
                                <option value="{{ $barang->kode_barang }}">{{ $barang->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-success w-100">Tambahkan ke Keranjang</button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <!-- Tabel Barang dalam Keranjang -->
    @if($barangDipinjam->isEmpty())
        <p>Keranjang peminjaman kosong. Silakan tambahkan barang yang ingin dipinjam.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangDipinjam as $detail)
                    <tr>
                        <td>{{ $detail->barang->kode_barang }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>
                            <!-- Form untuk menghapus barang -->
                            <form action="{{ route('keranjang.remove', $detail->kode_detail) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tombol Ajukan Peminjaman Barang -->
        <form action="{{ route('keranjang.submit') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Ajukan Peminjaman Barang</button>
        </form>
    @endif
</div>
@endsection
