@extends('masteruser')

@section('content')
<style>
    /* Styling for the main content */
    .content-wrapper {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
    }

    /* Add margin-top to the container */
    .container {
        padding-top: 30px; /* Adjust the margin-top value as needed */
    }

    /* Title Styling */
    .page-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
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
        padding: 10px 20px;
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

    .footer-buttons .btn-warning {
        background-color: #ffc107;
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
        Keranjang Peminjaman Barang
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
    
    <!-- Keranjang Peminjaman Barang -->
    <div class="table-container">
        <h3>Barang yang sudah ada di keranjang</h3>
        @if($barangDipinjam->isEmpty())
            <p>Keranjang Anda kosong. Silakan tambahkan barang.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangDipinjam as $detail)
                    @if ($detail->barang)
                        <tr>
                            <td>{{ $detail->barang->kode_barang }}</td>
                            <td>{{ $detail->barang->nama_barang }}</td>
                            <td>
                                <form action="{{ route('keranjang.remove', $detail->kode_detail) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @else
                        <em>Barang tidak tersedia</em>
                    @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Menampilkan Barang Tersedia untuk Dipinjam -->
    <div class="table-container">
        <h3>Barang Tersedia</h3>
        @if($barangTersedia->isEmpty())
            <p>Maaf, tidak ada barang yang tersedia pada rentang waktu ini.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangTersedia as $barang)
                        <tr>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>
                                <form action="{{ route('keranjang.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kode_barang" value="{{ $barang->kode_barang }}">
                                    <input type="hidden" name="tanggal_req_pinjam" value="{{ request('tanggal_pinjam_barang') }}">
                                    <input type="hidden" name="tanggal_req_kembali" value="{{ request('tanggal_kembali_barang') }}">
                                    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $barangTersedia->links('pagination::bootstrap-4') }}
    </div>

    <!-- Tombol Submit untuk Menyelesaikan Peminjaman -->
    <div class="footer-buttons">
        <form action="{{ route('keranjang.submit') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Ajukan Peminjaman</button>
        </form>
        <a href="/detail" class="btn btn-warning">
            Back
        </a>
    </div>
</div>

@endsection
