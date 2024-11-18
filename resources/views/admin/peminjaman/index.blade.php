@extends('masteradmin')

@section('content')
<div class="container mt-4">
    <h2>Approval Peminjaman</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Kode Pinjam</th>
                <th>User</th>
                <th>Tanggal Pinjam</th>
                <th>Ruangan</th>
                <th>Barang Dipinjam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $pinjam)
                <tr>
                    <td>{{ $pinjam->kode_pinjam }}</td>
                    <td>{{ $pinjam->user->name }}</td>
                    <td>{{ $pinjam->tanggal_pinjam }}</td>
                    <td>{{ $pinjam->ruang->nama_ruang ?? '-' }}</td>
                    <td>
                        <ul>
                            @foreach($pinjam->detailPeminjaman as $detail)
                                <li>{{ $detail->barang->nama_barang ?? 'Barang Tidak Tersedia' }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <form action="{{ route('admin.peminjaman.approve', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="{{ route('admin.peminjaman.reject', $pinjam->kode_pinjam) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
