<?php

namespace App\Console\Commands;

use App\Models\DetailPeminjamanRuang;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateStatusRuang extends Command
{
    // Nama dan signature command
    protected $signature = 'update:status-ruang';

    // Deskripsi command
    protected $description = 'Update status ruangan berdasarkan tanggal peminjaman';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();

        // Menemukan dan memperbarui data yang tanggal_kembali_ruang sama dengan tanggal hari ini
        $updated = DetailPeminjamanRuang::whereDate('tanggal_kembali_ruang', $today)
                                       ->update([
                                           'tanggal_pinjam_ruang' => null,
                                           'tanggal_kembali_ruang' => null
                                       ]);

        $this->info("Data berhasil diperbarui: {$updated} record(s)"); 
    }
}
