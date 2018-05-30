<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    protected $table = 'phieu_nhap';

    protected $fillable = [
        'MaPN', 'MaNV', 'MaKVT', 'MaNCC', 'NoiDung',
    ];

    protected $primaryKey = "MaPN";

    public $incrementing = false;

    public function NhanVien(){
        return $this->belongsTo('App\NhanVien','MaNV', 'MaNV');
    }

    public function KhoVatTu(){
        return $this->belongsTo('App\KhoVatTu','MaKVT', 'MaKVT');
    }

    public function NhaCungCap(){
        return $this->belongsTo('App\NhaCungCap','MaNCC', 'MaNCC');
    }
}
