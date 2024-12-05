@extends('masteradmin')

@section('content')
    <!-- Page Title -->
    <div class="page-title" style="margin-top: 20px; padding: 10px 20px; background-color: white; font-size: 20px; font-weight: bold; border-left: 5px solid #0b4d93;">
        Laporan Peminjaman
    </div>

    <!-- Filter Section -->
    <form method="GET" action="{{ route('admin.peminjaman.laporan') }}" class="mb-4">
        <div class="filter-container" style="display: flex; flex-wrap: wrap; align-items: center; gap: 15px; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 20px; background-color: #fff;">
            <!-- Rentang Tanggal Mulai -->
            <div style="flex: 1; min-width: 200px;">
                <label for="start-date" style="display: block; font-size: 14px; margin-bottom: 5px; font-weight: bold;">Rentang Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: 'Poppins', sans-serif; width: 100%;">
            </div>

            <!-- Rentang Tanggal Selesai -->
            <div style="flex: 1; min-width: 200px;">
                <label for="end-date" style="display: block; font-size: 14px; margin-bottom: 5px; font-weight: bold;">Rentang Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: 'Poppins', sans-serif; width: 100%;">
            </div>

            <!-- Status -->
            <div style="flex: 1; min-width: 200px;">
                <label for="status" style="display: block; font-size: 14px; margin-bottom: 5px; font-weight: bold;">Status</label>
                <select id="status" name="status" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: 'Poppins', sans-serif; width: 100%;">
                    <option value="">Semua</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Belum Selesai" {{ request('status') == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Canceled" {{ request('status') == 'Canceled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <button style="background-color: #007bff; color: #fff; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease;">Filter</button>
        </div>
    </form>

    <!-- Table Container -->
    <div class="table-container" style="background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead style="background-color: #000000; color: #fff;">
                <tr>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">Kode Peminjaman</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">Nama User</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">Tanggal Pinjam</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">Tanggal Rentang</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">Tanggal Kembali</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd; width: 100px;">Ruang</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">Barang</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($peminjaman as $pinjam)
                <tr>
                    <td style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">{{ $pinjam->kode_pinjam }}</td>
                    <td style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">{{ $pinjam->user->name }}</td>
                    <td style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">{{ $pinjam->tanggal_pinjam }}</td>
                    <td style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">
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
                    <td style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;">{{ $pinjam->tanggal_kembali ?? '-' }}</td>
                    <td style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;
                        max-width: 150px;
                        white-space: nowrap;
                        overflow: hidden; 
                        text-overflow: ellipsis;
                    ">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($pinjam->detailPeminjamanRuang as $detail)
                                <li>{{ $detail->ruang->nama_ruang ?? '-' }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd;
                        max-width: 150px;
                        white-space: nowrap;
                        overflow: hidden; 
                        text-overflow: ellipsis;
                    ">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($pinjam->detailPeminjaman as $detail)
                                <li>{{ $detail->barang->nama_barang ?? '-'}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="font-weight: bold; padding: 15px; text-align: left; border-bottom: 1px solid #ddd; 
                        @if($pinjam->status == 'Canceled')
                            color: red;
                        @elseif($pinjam->status == 'Selesai')
                            color: green;
                        @elseif($pinjam->status == 'Belum Selesai')
                            color: blue;
                        @elseif($pinjam->status == 'Pending')
                            color: #FFA500;
                        @else
                            color: black;
                        @endif
                    ">{{ $pinjam->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding: 15px; text-align: center; font-size: 14px; background-color: #f8d7da; color: #721c24; border-bottom: 1px solid #ddd;">
                        Belum ada data peminjaman.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
