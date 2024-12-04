<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            'kode_barang' => 'BRG-MI_001',
            'nama_barang' => 'Proyektor',
            'status' => 'Tersedia',
        ]);

        Barang::create([
            'kode_barang' => 'BRG-MI_002',
            'nama_barang' => 'Kabel VGA',
            'status' => 'Tersedia',
        ]);

        Barang::create([
            'kode_barang' => 'BRG-MI_003',
            'nama_barang' => 'Converter HDMI',
            'status' => 'Tersedia',
        ]);

        Barang::create([
            'kode_barang' => 'BRG-MI_004',
            'nama_barang' => 'Kabel HDMI',
            'status' => 'Tersedia',
        ]);
    }
}
