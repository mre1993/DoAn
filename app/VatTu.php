<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VatTu extends Model
{
    protected $table = 'vat_tu';

    protected $fillable = [
        'id', 'MaVT', 'TenVT', 'DVT', 'MaNCC', 'MaLoaiVT', 'MoTa'
    ];

    public $timestamps = false;

    public function LoaiVatTu(){
        return $this->belongsTo('App\TheLoai','MaLoaiVT', 'MaLoaiVT');
    }

    public function NhaCungCap(){
        return $this->belongsTo('App\NhaCungCap','MaNCC','MaNCC');
    }
}
