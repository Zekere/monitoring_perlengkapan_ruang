<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiwayatBarang;
use Carbon\Carbon;

class ResetRiwayatBulanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'riwayat:reset-bulanan 
                            {--keep-months=3 : Berapa bulan data yang akan di-keep}
                            {--force : Force reset tanpa konfirmasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset riwayat barang setiap bulan (hapus data lama)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $keepMonths = $this->option('keep-months');
        $force = $this->option('force');
        
        $this->info('═══════════════════════════════════════════════');
        $this->info('   RESET RIWAYAT PENGECEKAN BARANG BULANAN    ');
        $this->info('═══════════════════════════════════════════════');
        $this->newLine();

        // Hitung tanggal batas
        $cutoffDate = Carbon::now()->subMonths($keepMonths)->startOfMonth();
        
        $this->info("Tanggal cutoff: {$cutoffDate->format('d F Y')}");
        $this->info("Data yang lebih lama dari tanggal ini akan dihapus");
        $this->newLine();

        // Hitung jumlah data yang akan dihapus
        $totalToDelete = RiwayatBarang::where('created_at', '<', $cutoffDate)->count();
        
        if ($totalToDelete == 0) {
            $this->info('✅ Tidak ada data yang perlu dihapus');
            return 0;
        }

        $this->warn("⚠️  {$totalToDelete} record akan dihapus");
        $this->newLine();

        // Konfirmasi jika tidak force
        if (!$force) {
            if (!$this->confirm('Lanjutkan reset riwayat?')) {
                $this->error('❌ Reset dibatalkan');
                return 1;
            }
        }

        // Progress bar
        $bar = $this->output->createProgressBar($totalToDelete);
        $bar->start();

        // Hapus data per batch untuk performa
        $deleted = 0;
        RiwayatBarang::where('created_at', '<', $cutoffDate)
            ->chunk(1000, function ($records) use (&$deleted, $bar) {
                foreach ($records as $record) {
                    $record->delete();
                    $deleted++;
                    $bar->advance();
                }
            });

        $bar->finish();
        $this->newLine(2);

        // Summary
        $this->info('═══════════════════════════════════════════════');
        $this->info('✅ Reset riwayat selesai!');
        $this->info("📊 Total data dihapus: {$deleted} record");
        $this->info("📅 Data sebelum: {$cutoffDate->format('d F Y')}");
        $this->info('═══════════════════════════════════════════════');

        // Log ke file
        \Log::info("Riwayat reset: {$deleted} records dihapus", [
            'cutoff_date' => $cutoffDate,
            'keep_months' => $keepMonths
        ]);

        return 0;
    }
}