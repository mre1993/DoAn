<?php

namespace App\Console;

use App\ChiTietKhoVT;
use App\ChiTietPhieuNhap;
use App\PhieuNhap;
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
        'App\Console\Commands\Inspire',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $vatTu = \App\VatTu::all();
            foreach($vatTu as $item){
                $itemKho = DB::table('chi_tiet_kho_vat_tu')
                    ->select(DB::raw('SUM(SoLuongTon) as SoLuongTon'))
                    ->where('MaVT',$item->MaVT)->get();
                $itemNhap = DB::table('chi_tiet_phieu_nhap')
                    ->join('phieu_nhap','phieu_nhap.MaPN','chi_tiet_phieu_nhap.MaPN')
                    ->select(DB::raw('SUM(SoLuong) as SoLuong'),DB::raw('SUM(ThanhTien) as ThanhTien'))
                    ->where('MaVT',$item->MaVT)
                    ->whereMonth('created_at','=',\Carbon\Carbon::now()->month)->get();
                $itemXuat = DB::table('chi_tiet_phieu_xuat')
                    ->join('phieu_xuat','phieu_xuat.MaPhieuXuat','chi_tiet_phieu_xuat.MaPhieuXuat')
                    ->select(DB::raw('SUM(SoLuong) as SoLuong'),DB::raw('SUM(ThanhTien) as ThanhTien'))
                    ->where('MaVT',$item->MaVT)
                    ->whereMonth('created_at','=',\Carbon\Carbon::now()->month)->get();
                $tonDauThang = $itemKho->SoLuongTon - $itemNhap->SoLuong + $itemXuat->SoLuong;
                $donGia = ($tonDauThang*$item->DonGia + $itemNhap->ThanhTien)/($tonDauThang + $itemNhap->SoLuong);
                $item->DonGia = $donGia;
                $item->save();
            }
        })->when(function () {
            return \Carbon\Carbon::now()->endOfMonth()->isToday();
        })->at('23:59');
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
