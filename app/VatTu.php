<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VatTu extends Model
{
    protected $table = 'vat_tu';

    protected $fillable = [
        'MaVT', 'TenVT', 'DVT', 'MaNCC', 'MaLoaiVT', 'MoTa', 'DonGia'
    ];

    protected $primaryKey = "MaVT";

    public $timestamps = false;

    public $incrementing = false;

    public function LoaiVatTu(){
        return $this->belongsTo('App\TheLoai','MaLoaiVT', 'MaLoaiVT');
    }

    public function NhaCungCap(){
        return $this->belongsTo('App\NhaCungCap','MaNCC','MaNCC');
    }
}
