<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuNhap extends Model
{
    protected $table = 'chi_tiet_phieu_nhap';

    protected $fillable = [
        'ID', 'MaPN', 'MaVT', 'SoLuong', 'DonGia', 'ThanhTien'
    ];

    protected $primaryKey = "ID";

    public $timestamps = false;

    public function VatTu(){
        return $this->belongsTo('App\VatTu','MaVT', 'MaVT');
    }
}
