<?php

namespace App\Console;

use App\ChiTietKhoVT;
use App\ChiTietPhieuNhap;
use App\PhieuNhap;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\updateDonGia::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('VatTu:updateDonGia')->when(function () {
//            return \Carbon\Carbon::now()->endOfMonth()->isToday();
//        })->at('23:59')->cron('*/5 ****');
        $schedule->command('VatTu:updateDonGia')->everyMinute()->cron('*/5 ****');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
