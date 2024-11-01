
@extends('masteradmin')



@section('content')
<!-- Small boxes (Stat box) -->
<div class="row justify-content-center mx-auto mt-3">
    <!-- Total Barang -->
    <div class="col-md-4 col-6">
        <div class="small-box bg-info">
            <div class="inner text-white">
                <h3>{{ $totalBarang }}</h3>
                <p>Total Barang</p>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>

    <!-- Total Ruang -->
    <div class="col-md-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner text-white">
                <h3>{{ $totalRuang }}</h3>
                <p>Total Ruang</p>
            </div>
            <div class="icon">
                <i class="ion ion-home"></i>
            </div>
        </div>
    </div>

    

    <!-- Total Users -->
    <div class="col-md-4 col-6">
        <div class="small-box bg-primary">
            <div class="inner text-white">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
        </div>
    </div>
</div>
@endsection
