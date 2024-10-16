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

        <h1 class="mb-4">Data Barang</h1>

        <div class="mb-3 d-flex justify-content-between">
            <div>
                <label for="show" class="mr-2">Show</label>
                <select id="show" class="custom-select w-auto d-inline-block">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div>
                <input type="text" class="form-control w-75 d-inline-block" placeholder="Search">
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>No</th>
                    <th>Nama alat</th>
                    <th>Status</th>
                  
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang->nama }}</td>
                        <td>{{ $barang->status ? 'Tersedia' : 'Tidak Tersedia' }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
