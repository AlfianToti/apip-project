@extends('masteruser')

@section('content')
<div class="container mt-5 mb-5 px-2">
    <div class="container-fluid">
        <h1 class="mb-4">Form Peminjaman</h1>

        <!-- Form untuk memilih barang -->
        <div class="form-group">
            <label for="barang">Pilih Barang</label>
            <select id="barang" class="form-control">
                @foreach($barang as $item)
                    <option value="{{ $item->id }}" data-nama="{{ $item->nama }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <button id="tambahBarang" class="btn btn-primary">Tambah ke Keranjang</button>

        <!-- Tabel Keranjang -->
        <h4 class="mt-4">Keranjang</h4>
        <table class="table table-bordered" id="keranjangTable">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <!-- Form untuk memilih ruang -->
        <div class="form-group mt-4">
            <label for="ruang">Pilih Ruang</label>
            <select id="ruang" name="ruang_id" class="form-control">
                @foreach($ruang as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Form untuk submit -->
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <input type="hidden" name="barang_ids" id="barangIds">
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"> <!-- Contoh pengisian user_id -->
            <button type="submit" class="btn btn-success mt-3">Submit Peminjaman</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const barangSelect = document.getElementById('barang');
        const tambahBarangBtn = document.getElementById('tambahBarang');
        const keranjangTable = document.getElementById('keranjangTable').querySelector('tbody');
        const barangIdsInput = document.getElementById('barangIds');
        let barangIds = [];

        tambahBarangBtn.addEventListener('click', function () {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            const barangId = selectedOption.value;
            const barangNama = selectedOption.getAttribute('data-nama');

            if (barangIds.includes(barangId)) {
                alert('Barang sudah ada di keranjang!');
                return;
            }

            barangIds.push(barangId);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${barangNama}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusBarang('${barangId}', this)">Hapus</button></td>
            `;
            keranjangTable.appendChild(row);

            // Update input hidden
            barangIdsInput.value = JSON.stringify(barangIds);
        });
    });

    function hapusBarang(barangId, button) {
        const barangIdsInput = document.getElementById('barangIds');
        let barangIds = JSON.parse(barangIdsInput.value);

        barangIds = barangIds.filter(id => id !== barangId);
        barangIdsInput.value = JSON.stringify(barangIds);

        // Hapus baris tabel
        button.closest('tr').remove();
    }
</script>
@endsection
