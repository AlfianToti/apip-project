@extends('masteruser')

@section('content')
<div class="container">
    <h2>Buat Janji Peminjaman</h2>

    <!-- Pesan Error -->
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form untuk Janji Peminjaman -->
    <form action="{{ route('peminjaman.ruangan.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal_pinjam">Tanggal Mulai</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ request('tanggal_pinjam') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="form-control" value="{{ request('tanggal_kembali') }}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Buat Peminjaman</button>
    </form>
</div>
@endsection
