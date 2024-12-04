@extends('masteradmin')

@section('content')
<div class="container">
    <h2>Approval Pengembalian</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                            <button class="btn btn-success btn-sm">Setujui</button>
                        </form>
                        <form action="{{ route('admin.peminjaman.rejectPengembalian', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada permintaan pengembalian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
