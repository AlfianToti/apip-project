@extends('masteruser')

@section('content')
<style>
    .page-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .table-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead {
        background-color: #333;
        color: #fff;
    }

    table thead th {
        padding: 15px;
        font-size: 14px;
        text-align: left;
        border-bottom: 2px solid #ddd;
    }

    table tbody tr {
        border-bottom: 1px solid #ddd;
    }

    table tbody tr:hover {
        background-color: #f1f1f1;
    }

    table tbody td {
        padding: 15px;
        font-size: 14px;
        text-align: left;
    }

    table tbody .action-buttons {
        display: flex;
        gap: 10px;
    }

    .approve-button, .detail-button {
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .approve-button {
        background-color: #284ea7;
        color: #fff;
    }

    .approve-button:hover {
        background-color: #23c831;
    }

    .detail-button {
        background-color: #708090;
        color: #fff;
    }

    .detail-button:hover {
        background-color: #23c831;
    }

    .empty-message {
        padding: 15px;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        background-color: #f8d7da;
        color: #721c24;
        border-bottom: 1px solid #ddd;
    }
</style>

<div class="container">
    <div class="page-title" style="margin-top: 20px; padding: 10px 20px; background-color: white; font-size: 20px; font-weight: bold; border-left: 5px solid #0b4d93;">
        Riwayat Peminjaman
    </div>
    
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

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Pinjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Rentang</th>
                    <th>Tanggal Kembali</th>
                    <th>Ruang</th>
                    <th>Barang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $pinjam)
                    <tr>
                        <td>{{ $pinjam->kode_pinjam }}</td>
                        <td>{{ $pinjam->tanggal_pinjam }}</td>
                        <td>
                            @if($pinjam->detailPeminjamanRuang->isNotEmpty())
                                {{ $pinjam->detailPeminjamanRuang->first()->tanggal_req_pinjam }} s.d. 
                                {{ $pinjam->detailPeminjamanRuang->first()->tanggal_req_kembali }}
                            @elseif($pinjam->detailPeminjaman->isNotEmpty())
                                {{ $pinjam->detailPeminjaman->first()->tanggal_req_pinjam }} s.d. 
                                {{ $pinjam->detailPeminjaman->first()->tanggal_req_kembali }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
                        <td>
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
                        <td style="font-weight: bold;
                        @if($pinjam->status == 'Canceled')
                            color: red;
                        @elseif($pinjam->status == 'Selesai')
                            color: green;
                        @elseif($pinjam->status == 'Belum Selesai')
                            color: blue;
                        @elseif($pinjam->status == 'Pending')
                            color: #FFA500;
                        @else
                            color: black;
                        @endif
                        ">{{ $pinjam->status }}</td>
                        <td>
                            @if($pinjam->status === 'Belum Selesai')
                                <!-- Tombol Kembalikan -->
                                <form action="{{ route('peminjaman.kembalikan', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="approve-button">Kembalikan</button>
                                </form>
                            @endif
                            <!-- Tombol Detail -->
                            <a href="{{ route('peminjaman.show', $pinjam->kode_pinjam) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-message">
                            Belum ada peminjaman yang dilakukan.
                        </td>
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
