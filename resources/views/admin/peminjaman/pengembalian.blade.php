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
                <th>Tanggal Kembali</th>
                <th>Barang Dipinjam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $pinjam)
                <tr>
                    <td>{{ $pinjam->kode_pinjam }}</td>
                    <td>{{ $pinjam->user->name }}</td>
                    <td>{{ $pinjam->tanggal_pinjam }}</td>
                    <td>{{ $pinjam->tanggal_kembali }}</td>
                    <td>
                        <ul>
                            @foreach($pinjam->detailPeminjaman as $detail)
                                <li>{{ $detail->barang->nama_barang }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <form action="{{ route('admin.peminjaman.approvePengembalian', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Setujui</button>
                        </form>
                        <form action="{{ route('admin.peminjaman.reject', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
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
