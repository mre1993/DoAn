<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietPhanXuong extends Model
{
    protected $table = 'chi_tiet_phan_xuong';

    protected $fillable = [
        'id','MaPX', 'MaVT', 'SoLuongTon', 'GhiChu'
    ];

    public $timestamps = false;

    public function VatTu(){
        return $this->belongsTo('App\VatTu','MaVT', 'MaVT');
    }

    public function PhanXuong(){
        return $this->belongsTo('App\PhanXuong','MaPX', 'MaPX');
    }
}
