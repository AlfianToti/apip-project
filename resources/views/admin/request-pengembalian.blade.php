@extends('masteradmin')

@section('content')
    <div class="container mt-5 mb-5 px-2">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <h1 class="mb-4">Persetujuan Permintaan Pengembalian</h1>

            <table class="table table-bordered table-striped">
                <thead style="background-color: #00a2ea; color: white;">
                    <tr>
                        <th>ID Peminjaman</th>
                        <th>Nama Pengguna</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengembalianRequests as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->id }}</td>
                            <td>{{ $peminjaman->user->name }}</td> <!-- Asumsi relasi ke user -->
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td>{{ ucfirst($peminjaman->status) }}</td>
                            <td>
                                <form action="{{ route('admin.request.pengembalian.approve', $peminjaman->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                </form>
                                <form action="{{ route('admin.request.pengembalian.reject', $peminjaman->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
