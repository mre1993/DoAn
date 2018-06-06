<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    protected $table = 'phieu_nhap';

    protected $fillable = [
        'MaPN', 'MaNV', 'MaPX', 'MaNCC', 'NoiDung',
    ];

    protected $primaryKey = "MaPN";

    public $incrementing = false;

    public function PhanXuong(){
        return $this->belongsTo('App\PhanXuong','MaPX', 'MaPX');
    }

    public function NhanVien(){
        return $this->belongsTo('App\NhanVien','MaNV', 'MaNV');
    }

    public function NhaCungCap(){
        return $this->belongsTo('App\NhaCungCap','MaNCC', 'MaNCC');
    }
}
