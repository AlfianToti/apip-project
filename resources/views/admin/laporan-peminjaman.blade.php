@extends('masteradmin')

@section('content')
<div class="container mt-5 mb-5 px-2">
    <div class="container-fluid">
        <h1 class="mb-4">Laporan Peminjaman</h1>
        
        <table class="table table-bordered table-striped">
            <thead style="background-color: #00a2ea; color: white;">
                <tr>
                    <th>ID Peminjaman</th>
                    <th>Nama Pengguna</th>
                    <th>Barang</th>
                    <th>Ruang</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjamanRecords as $record)
                <tr>
                    <td>{{ $record->kode_pinjam }}</td>
                    <td>{{ $record->user->name }}</td>
                    <td>{{ $record->barang->nama_barang ?? 'N/A' }}</td>
                    <td>{{ $record->ruang->nama_ruang ?? 'N/A' }}</td>
                    <td>{{ $record->tanggal_pinjam }}</td>
                    <td>{{ $record->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                    <td>{{ ucfirst($record->status) }}</td>
                    <td>{{ $record->catatan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
