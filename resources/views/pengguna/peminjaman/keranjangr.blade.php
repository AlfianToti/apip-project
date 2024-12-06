@extends('masteruser')

@section('content')
<style>
    .container {
        padding-top: 30px;
    }
    .page-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Styling for the main content */
    .content-wrapper {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
    }

    /* Table Styling */
    .table-container h3 {
        font-size: 22px;
        margin-bottom: 15px;
        color: #333;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .table-container table th,
    .table-container table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table-container table th {
        background-color: #040d16;
        color: white;
    }

    .table-container table td {
        background-color: #f9f9f9;
    }

    .table-container table tr:hover td {
        background-color: #f1f1f1;
    }

    .table-container table td button {
        background-color: #007bff;
        color: white;
        padding: 10px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s, transform 0.3s;
    }

    .table-container table td button:hover {
        background-color: #0056b3;
        transform: translateY(-3px);
    }

    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 8px 16px;
        margin: 0 5px;
        border: 1px solid #ddd;
        text-decoration: none;
        color: #007bff;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .pagination a:hover {
        background-color: #007bff;
        color: white;
    }

    /* Buttons for Next and Cancel */
    .footer-buttons {
        margin-top: 30px;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .footer-buttons button {
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .footer-buttons .btn-success {
        background-color: #28a745;
        color: white;
    }

    .footer-buttons .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .footer-buttons button:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transform: translateY(-3px);
    }

</style>

<div class="container">
    <div class="page-title" style="margin-top: 20px; padding: 10px 20px; background-color: white; font-size: 20px; font-weight: bold; border-left: 5px solid #0b4d93;">
        Keranjang Peminjaman Ruang
    </div>

    <!-- Pesan sukses atau error -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Keranjang Peminjaman Ruangan -->
    <div class="table-container">
        <h3>Ruangan yang sudah ada di keranjang</h3>
        @if($ruangDipinjam->isEmpty())
            <p>Keranjang Anda kosong. Silakan tambahkan ruangan.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Ruang</th>
                        <th>Nama Ruang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ruangDipinjam as $detail)
                    @if ($detail->ruang)
                        <tr>
                            <td>{{ $detail->ruang->kode_ruang }}</td>
                            <td>{{ $detail->ruang->nama_ruang }}</td>
                            <td>
                                <form action="{{ route('detail.remove', $detail->kode_detail_ruang) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @else
                        <em>Ruangan tidak tersedia</em>
                    @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Menampilkan Ruangan Tersedia untuk Dipinjam -->
    <div class="table-container">
        <h3>Ruangan Tersedia</h3>
        @if($ruangTersedia->isNotEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Ruang</th>
                        <th>Nama Ruang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ruangTersedia as $ruang)
                        <tr>
                            <td>{{ $ruang->kode_ruang }}</td>
                            <td>{{ $ruang->nama_ruang }}</td>
                            <td>
                                <form action="{{ route('detail.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kode_ruang" value="{{ $ruang->kode_ruang }}">
                                    <input type="hidden" name="tanggal_req_pinjam" value="{{ request('tanggal_pinjam_ruang') }}">
                                    <input type="hidden" name="tanggal_req_kembali" value="{{ request('tanggal_kembali_ruang') }}">
                                    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Maaf, tidak ada ruangan yang tersedia pada rentang waktu ini.</p>
        @endif
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $ruangTersedia->links('pagination::bootstrap-4') }}
    </div>

    <!-- Tombol Submit untuk Menyelesaikan Peminjaman -->
    <div class="footer-buttons">
        <form action="{{ route('detail.submit') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Next</button>
        </form>

        <form action="{{ route('peminjaman.cancel') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Cancel</button>
        </form>
    </div>
</div>

@endsection
