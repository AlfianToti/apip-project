@extends('masteradmin')

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

    .approve-button, .reject-button {
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

    .reject-button {
        background-color: #dc3545;
        color: #fff;
    }

    .reject-button:hover {
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
    <!-- Judul Halaman -->
    <div class="page-title" style="margin-top: 20px; padding: 10px 20px; background-color: white; font-size: 20px; font-weight: bold; border-left: 5px solid #0b4d93;">
        Approval Pengembalian
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Pinjam</th>
                    <th>User</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Rentang</th>
                    <th>Tanggal Kembali</th>
                    <th>Ruang</th>
                    <th>Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($peminjaman as $pinjam)
                <tr>
                    <td>{{ $pinjam->kode_pinjam }}</td>
                    <td>{{ $pinjam->user->name }}</td>
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
                    <td>{{ $pinjam->tanggal_kembali }}</td>
                    <td>
                        <ul>
                            @foreach($pinjam->detailPeminjamanRuang as $detail)
                                <li>{{ $detail->ruang->nama_ruang ?? '-' }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach($pinjam->detailPeminjaman as $detail)
                                <li>{{ $detail->barang->nama_barang ?? '-' }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <form action="{{ route('admin.peminjaman.approvePengembalian', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button class="approve-button" style="background-color: #1616be; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">Approve</button>
                        </form>
                        <form action="{{ route('admin.peminjaman.rejectPengembalian', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button class="reject-button" style="background-color: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">Tolak</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="empty-message">
                        Belum ada permintaan pengembalian.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
