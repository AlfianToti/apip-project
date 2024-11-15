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
        <div class="mb-3">
            <label for="kode_ruang" class="form-label">Pilih Ruangan (Opsional)</label>
            <select name="kode_ruang" id="kode_ruang" class="form-select">
                <option value="">-- Tidak Meminjam Ruangan --</option>
                @foreach($ruang as $item)
                    <option value="{{ $item->kode_ruang }}">{{ $item->nama_ruang }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Buat Peminjaman</button>
    </form>
</div>
@endsection
