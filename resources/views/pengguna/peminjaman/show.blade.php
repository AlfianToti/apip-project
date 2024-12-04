@extends('masteruser')

@section('content')
<div class="container mt-4">
    <h2>Detail Peminjaman</h2>

    <table class="table table-bordered">
        <tr>
            <th>Kode Pinjam</th>
            <td>{{ $peminjaman->kode_pinjam }}</td>
        </tr>
        <tr>
            <th>Tanggal Pinjam</th>
            <td>{{ $peminjaman->tanggal_pinjam }}</td>
        </tr>
        <tr>
            <th>Tanggal Kembali</th>
            <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Rentang</th>
            <td>
                @if($peminjaman->detailPeminjamanRuang->isNotEmpty())
                    {{ $peminjaman->detailPeminjamanRuang->first()->tanggal_req_pinjam }} s.d. 
                    {{ $peminjaman->detailPeminjamanRuang->first()->tanggal_req_kembali }}
                @elseif($peminjaman->detailPeminjaman->isNotEmpty())
                    {{ $peminjaman->detailPeminjaman->first()->tanggal_req_pinjam }} s.d. 
                    {{ $peminjaman->detailPeminjaman->first()->tanggal_req_kembali }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th>Ruangan Dipinjam</th>
            <td>
                <ul>
                    @foreach($peminjaman->detailPeminjamanRuang as $detail)
                        <li>{{ $detail->ruang->nama_ruang }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <th>Barang Dipinjam</th>
            <td>
                <ul>
                    @foreach($peminjaman->detailPeminjaman as $detail)
                        <li>{{ $detail->barang->nama_barang }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $peminjaman->status }}</td>
        </tr>
    </table>

    <a href="{{ route('peminjaman.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
