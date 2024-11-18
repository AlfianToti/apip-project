@extends('masteruser')

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

        <h1 class="mb-4">Dashboard</h1>

        <div class="row">
            <!-- Kelas -->
            <div class="col-md-4">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body d-flex align-items-center">
                        <img src="/images/Classroom.png" alt="" style="width: 50px; height: 50px; margin-right: 10px;">
                        <h3>{{ $jumlahKelas }} Kelas</h3>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('kelas.index') }}">More Info</a>
                        <div class="small text-white"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </div>
            </div>
            <!-- Barang -->
            <div class="col-md-4">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body d-flex align-items-center">
                        <img src="/images/Inventory.png" alt="" style="width: 50px; height: 50px; margin-right: 10px;">
                        <h3>{{ $jumlahBarang }} Barang</h3>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('alat.index') }}">More Info</a>
                        <div class="small text-white"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </div>
            </div>
            <!-- Riwayat Peminjaman -->
            <div class="col-md-4">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body d-flex align-items-center">
                        <img src="/images/Product.png" alt="" style="width: 50px; height: 50px; margin-right: 10px;">
                        <h3>{{ $jumlahPeminjaman }} Riwayat Peminjaman</h3>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('peminjaman.index') }}">More Info</a>
                        <div class="small text-white"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
