<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhieuXuat extends Model
{
    protected $table = 'phieu_xuat';

    protected $fillable = [
        'MaPhieuXuat', 'MaNV', 'MaPX', 'NoiDung', 'MaKVT'
    ];

    protected $primaryKey = "MaPhieuXuat";

    public $incrementing = false;

    public function PhanXuong(){
        return $this->belongsTo('App\PhanXuong','MaPX', 'MaPX');
    }

    public function NhanVien(){
        return $this->belongsTo('App\NhanVien','MaNV', 'MaNV');
    }

    public function KhoVatTu(){
        return $this->belongsTo('App\KhoVatTu','MaKVT', 'MaKVT');
    }
}
