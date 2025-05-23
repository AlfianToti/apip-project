
@extends('masteradmin')

@section('content')
    <div class="container mt-5 mb-5 px-5">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <h1 class="mb-4">Tambah Ruang Baru</h1>
            <form action="{{ route('ruang.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="kode_ruang">Kode Ruang:</label>
                    <input type="text" class="form-control" id="kode_ruang" name="kode_ruang" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nama_ruang">Nama Ruang:</label>
                    <input type="text" class="form-control" id="nama_ruang" name="nama_ruang" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('ruang.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn" style="background-color: #00a2ea; color: white;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
