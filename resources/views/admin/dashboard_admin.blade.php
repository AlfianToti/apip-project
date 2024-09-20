<!-- File: dashboard_admin.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-school"></i> Data Kelas
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-box"></i> Data Barang
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-users"></i> Data User
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-book"></i> Data Peminjaman
                </a>
            </div>
        </div>
        <div class="col-md-10">
            <h2>Dashboard</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card 1</h5>
                            <p class="card-text">Some example text.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card 2</h5>
                            <p class="card-text">Some example text.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card 3</h5>
                            <p class="card-text">Some example text.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card 4</h5>
                            <p class="card-text">Some example text.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card 5</h5>
                            <p class="card-text">Some example text.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card 6</h5>
                            <p class="card-text">Some example text.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
