<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ruang::create([
            'kode_ruang' => 'RG-MI_001',
            'nama_ruang' => 'MI-1',
            'status' => 'Tersedia',
        ]);
        
        Ruang::create([
            'kode_ruang' => 'RG-MI_002',
            'nama_ruang' => 'MI-2',
            'status' => 'Tersedia',
        ]);
    }
}
