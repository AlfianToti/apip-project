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
    <!-- Keranjang Peminjaman Ruangan -->
    <h3>Ruangan yang sudah ada di keranjang</h3>
    @if($ruangDipinjam->isEmpty())
        <p>Keranjang Anda kosong. Silakan tambahkan ruangan.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Ruang</th>
                    <th>Nama Ruang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ruangDipinjam as $detail)
                @if ($detail->ruang)
                    <tr>
                        <td>{{ $detail->ruang->kode_ruang }}</td>
                        <td>{{ $detail->ruang->nama_ruang }}</td>
                        <td>
                            <form action="{{ route('detail.remove', $detail->kode_detail_ruang) }}" method="POST">
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

    <!-- Menampilkan Ruangan Tersedia untuk Dipinjam -->
    <h3>Ruangan Tersedia</h3>
    @if($ruangTersedia->isNotEmpty())<table class="table">
            <thead>
                <tr>
                    <th>Kode Ruang</th>
                    <th>Nama Ruang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ruangTersedia as $ruang)
                    <tr>
                        <td>{{ $ruang->kode_ruang }}</td>
                        <td>{{ $ruang->nama_ruang }}</td>
                        <td>
                            <form action="{{ route('detail.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kode_ruang" value="{{ $ruang->kode_ruang }}">
                                <input type="hidden" name="tanggal_req_pinjam" value="{{ request('tanggal_pinjam_ruang') }}">
                                <input type="hidden" name="tanggal_req_kembali" value="{{ request('tanggal_kembali_ruang') }}">
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Maaf, tidak ada ruangan yang tersedia pada rentang waktu ini.</p>
    @endif

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $peminjaman->links('pagination::bootstrap-4') }}
    </div>

<!-- Tombol Submit untuk Menyelesaikan Peminjaman -->
    <div class="mt-4">
        <form action="{{ route('detail.submit') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Next</button>
        </form>
    </div>
    <div class="mt-4">
        <form action="{{ route('peminjaman.cancel') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-a-danger">Cancel</button>
        </form>
    </div>
</div>
@endsection