@extends('masteruser')

@section('content')
<div class="container">
    <h2>Riwayat Peminjaman</h2>

    <!-- Pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Riwayat Peminjaman -->
    <table class="table">
        <thead>
            <tr>
                <th>Kode Pinjam</th>
                <th>Tanggal Pinjam</th>
                <th>Ruangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $pinjam)
                <tr>
                    <td>{{ $pinjam->kode_pinjam }}</td>
                    <td>{{ $pinjam->tanggal_pinjam }}</td>
                    <td>{{ $pinjam->ruang ? $pinjam->ruang->nama_ruang : '-' }}</td>
                    <td>{{ $pinjam->status }}</td>
                    <td>
                        <!-- Tombol untuk melihat detail peminjaman -->
                        <a href="{{ route('peminjaman.show', $pinjam->kode_pinjam) }}" class="btn btn-info">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada peminjaman yang dilakukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tombol Buat Peminjaman -->
    <a href="{{ route('peminjaman.ruangan.index') }}" class="btn btn-primary">Buat Peminjaman</a>
</div>
@endsection
