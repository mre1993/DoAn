<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietKhoVT extends Model
{
    protected $table = 'chi_tiet_kho_vat_tu';

    protected $fillable = [
        'id','MaKVT', 'MaVT', 'SoLuongTon', 'GhiChu', 'T'
    ];

    public $timestamps = false;

    public function VatTu(){
        return $this->belongsTo('App\VatTu','MaVT', 'MaVT');
    }

    public function KhoVT(){
        return $this->belongsTo('App\KhoVatTu','MaKVT', 'MaKVT');
    }
}
