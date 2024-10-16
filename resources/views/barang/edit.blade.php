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

            <h1 class="mb-4">Edit Barang</h1>
            <form action="{{ route('barang.update', $barang->kode_barang) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="nama">Nama Barang:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $barang->nama }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1" {{ $barang->status ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ !$barang->status ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn" style="background-color: #00a2ea; color: white;">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection
