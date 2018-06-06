<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuXuat extends Model
{
    protected $table = 'chi_tiet_phieu_xuat';

    protected $fillable = [
        'ID', 'MaPhieuXuat', 'MaVT', 'SoLuong', 'DonGia', 'ThanhTien'
    ];

    protected $primaryKey = "ID";

    public $timestamps = false;

    public function VatTu(){
        return $this->belongsTo('App\VatTu','MaVT', 'MaVT');
    }
}
