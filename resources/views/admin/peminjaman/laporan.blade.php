@extends('masteradmin')

@section('content')
<div class="container">
    <h2>Laporan Peminjaman</h2>

    <form method="GET" action="{{ route('admin.peminjaman.laporan') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Belum Selesai" {{ request('status') == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Canceled" {{ request('status') == 'Canceled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Kode Peminjaman</th>
                <th>Nama User</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Barang Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $pinjam)
                <tr>
                    <td>{{ $pinjam->kode_pinjam }}</td>
                    <td>{{ $pinjam->user->name }}</td>
                    <td>{{ $pinjam->tanggal_pinjam }}</td>
                    <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
                    <td>{{ $pinjam->status }}</td>
                    <td>
                        <ul>
                            @foreach($pinjam->detailPeminjaman as $detail)
                                <li>{{ $detail->barang->nama_barang }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
