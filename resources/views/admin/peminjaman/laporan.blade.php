@extends('masteradmin')

@section('content')
<div class="container">
    <h2>Laporan Peminjaman</h2>

    <form method="GET" action="{{ route('admin.peminjaman.laporan') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Rentang Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">Rentang Tanggal Selesai</label>
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
                <th>Tanggal Rentang</th>
                <th>Tanggal Kembali</th>
                <th>Ruang</th>
                <th>Barang</th>
                <th>Status</th>
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
                    <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
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
                                <li>{{ $detail->barang->nama_barang ?? '-'}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $pinjam->status }}</td>
                    
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
