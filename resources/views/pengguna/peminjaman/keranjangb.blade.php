@extends('masteruser')

@section('content')
<div class="container">
    <h2>Keranjang Peminjaman</h2>

    <!-- Pesan sukses atau error -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- Keranjang Peminjaman Barang -->
    <h3>Barang yang sudah ada di keranjang</h3>
    @if($barangDipinjam->isEmpty())
        <p>Keranjang Anda kosong. Silakan tambahkan barang.</p>
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
                @if ($detail->barang)
                    <tr>
                        <td>{{ $detail->barang->kode_barang }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>
                            <form action="{{ route('keranjang.remove', $detail->kode_detail) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @else
                    <em>Ruangan tidak tersedia</em>
                @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Menampilkan Barang Tersedia untuk Dipinjam -->
    <h3>Barang Tersedia</h3>
    @if($barangTersedia->isEmpty())
        <p>Maaf, tidak ada barang yang tersedia pada rentang waktu ini.</p>
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
                @foreach($barangTersedia as $barang)
                    <tr>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>
                            <form action="{{ route('keranjang.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kode_barang" value="{{ $barang->kode_barang }}">
                                <input type="hidden" name="tanggal_req_pinjam" value="{{ request('tanggal_pinjam_barang') }}">
                                <input type="hidden" name="tanggal_req_kembali" value="{{ request('tanggal_kembali_barang') }}">
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $peminjaman->links('pagination::bootstrap-4') }}
    </div>

    <!-- Tombol Submit untuk Menyelesaikan Peminjaman -->
    <div class="mt-4">
        <form action="{{ route('keranjang.submit') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Ajukan Peminjaman</button>
        </form>
    </div>
</div>
@endsection
