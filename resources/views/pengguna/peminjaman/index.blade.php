@extends('masteruser')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Riwayat Peminjaman</h2>

    <!-- Pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pesan error jika ada -->
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Tabel Riwayat Peminjaman -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Kode Pinjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Ruangan</th>
                    <th>Barang Dipinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $pinjam)
                    <tr>
                        <td>{{ $pinjam->kode_pinjam }}</td>
                        <td>{{ $pinjam->tanggal_pinjam }}</td>
                        <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
                        <td>
                        <!-- Daftar Ruang -->
                        @if($pinjam->detailPeminjamanRuang->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach($pinjam->detailPeminjamanRuang as $detail)
                                        <li>{{ $detail->ruang->nama_ruang ?? 'Ruang Tidak Tersedia' }}</li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <!-- Daftar Barang -->
                            @if($pinjam->detailPeminjaman->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach($pinjam->detailPeminjaman as $detail)
                                        <li>{{ $detail->barang->nama_barang ?? 'Barang Tidak Tersedia' }}</li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $pinjam->status }}</td>
                        <td>
                            @if($pinjam->status === 'Belum Selesai')
                                <!-- Tombol Kembalikan -->
                                <form action="{{ route('peminjaman.kembalikan', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                                </form>
                            @endif
                            <!-- Tombol Detail -->
                            <a href="{{ route('peminjaman.show', $pinjam->kode_pinjam) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada peminjaman yang dilakukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $peminjaman->links('pagination::bootstrap-4') }}
    </div>

    <!-- Tombol Buat Peminjaman -->
    <div class="mt-4">
        <a href="{{ route('peminjaman.ruangan.index') }}" class="btn btn-primary">Buat Peminjaman</a>
    </div>
</div>
@endsection
