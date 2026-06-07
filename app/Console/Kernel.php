<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\SppLoan;
use App\Models\SppInstallment;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            
            // 1. Tentukan batas tanggal toleransi (30 hari yang lalu dari hari ini)
            $batasMacet = Carbon::now()->subDays(30)->startOfDay();

            // 2. Cari semua loan_id yang memiliki angsuran tertunggak melebihi 30 hari
            $loanIdsTertunggak = SppInstallment::where('status_bayar', 'belum_bayar')
                ->where('tanggal_jatuh_tempo', '<=', $batasMacet)
                ->pluck('loan_id')
                ->unique();

            // 3. Jika ada yang menunggak, ubah status_loan induknya menjadi 'macet'
            if ($loanIdsTertunggak->isNotEmpty()) {
                SppLoan::whereIn('id', $loanIdsTertunggak)
                    ->where('status_loan', 'berjalan')
                    ->update(['status_loan' => 'macet']);
            }

        })->daily();
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
