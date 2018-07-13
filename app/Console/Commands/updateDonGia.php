<?php

namespace App\Console\Commands;

use App\VatTu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class updateDonGia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'VatTu:updateDonGia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $itemKho = DB::table('chi_tiet_kho_vat_tu')
            ->select(DB::raw('SUM(SoLuongTon) as SoLuongTon'),'MaVT')->get();
        foreach ($itemKho as $item) {
            $itemVT = VatTu::where('MaVT',$item->MaVT)->first();
            $itemNhap = DB::table('chi_tiet_phieu_nhap')
                ->join('phieu_nhap', 'phieu_nhap.MaPN', 'chi_tiet_phieu_nhap.MaPN')
                ->select(DB::raw('SUM(SoLuong) as SoLuong'), DB::raw('SUM(ThanhTien) as ThanhTien'))
                ->where('MaVT', $item->MaVT)
                ->whereMonth('phieu_nhap.created_at', '=', \Carbon\Carbon::now()->month)->first();
            $itemXuat = DB::table('chi_tiet_phieu_xuat')
                ->join('phieu_xuat', 'phieu_xuat.MaPhieuXuat', 'chi_tiet_phieu_xuat.MaPhieuXuat')
                ->select(DB::raw('SUM(SoLuong) as SoLuong'), DB::raw('SUM(ThanhTien) as ThanhTien'))
                ->where('MaVT', $item->MaVT)
                ->whereMonth('phieu_xuat.created_at', '=', \Carbon\Carbon::now()->month)->first();
            if(!$itemXuat){
                $itemXuat->SoLuong = 0;
            }
            if($itemNhap->SoLuong > 0){
                $tonDauThang = $item->SoLuongTon - $itemNhap->SoLuong + $itemXuat->SoLuong;
                $donGia = ($tonDauThang*$itemVT->DonGia + $itemNhap->ThanhTien) / ($tonDauThang + $itemNhap->SoLuong);
                $itemVT->DonGia = round($donGia);
                $itemVT->save();
            }
        }
    }
}
