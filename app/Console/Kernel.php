<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Reset riwayat setiap awal bulan jam 00:01
        $schedule->command('riwayat:reset-bulanan --force')
                 ->monthlyOn(1, '00:01')
                 ->timezone('Asia/Jakarta')
                 ->onSuccess(function () {
                     \Log::info('✅ Riwayat berhasil direset otomatis');
                 })
                 ->onFailure(function () {
                     \Log::error('❌ Gagal reset riwayat otomatis');
                 });

        // Backup database sebelum reset (opsional)
        $schedule->command('backup:run')
                 ->monthlyOn(1, '00:00')
                 ->timezone('Asia/Jakarta');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}