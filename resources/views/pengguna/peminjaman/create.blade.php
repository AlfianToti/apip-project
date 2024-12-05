@extends('masteruser')

@section('content')
<div class="container">
    <div class="page-title" style="margin-top: 20px; padding: 10px 20px; background-color: white; font-size: 20px; font-weight: bold; border-left: 5px solid #0b4d93;">
        Buat Peminjaman
    </div>

    <!-- Pesan Error -->
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form untuk Janji Peminjaman -->
    <form action="{{ route('peminjaman.ruangan.store') }}" method="POST">
        @csrf
        <div class="filter-container" style="display: flex; flex-wrap: wrap; align-items: center; gap: 15px; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 20px; background-color: #fff;">
            <!-- Rentang Tanggal Mulai -->
            <div style="flex: 1; min-width: 200px;">
                <label for="tanggal_pinjam" style="display: block; font-size: 14px; margin-bottom: 5px; font-weight: bold;">Tanggal Mulai</label>
                <input type="date" name="tanggal_pinjam" class="form-control" value="{{ request('tanggal_pinjam') }}">
            </div>

            <!-- Rentang Tanggal Selesai -->
            <div style="flex: 1; min-width: 200px;">
                <label for="end-date" style="display: block; font-size: 14px; margin-bottom: 5px; font-weight: bold;">Rentang Tanggal Selesai</label>
                <input type="date" name="tanggal_kembali" class="form-control" value="{{ request('tanggal_kembali') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Buat Peminjaman</button>
    </form>
</div>
@endsection
