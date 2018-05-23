<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    protected $table = 'nha_cung_cap';

    protected $fillable = [
        'MaNCC', 'TenNCC', 'DiaChi', 'SDT', 'Fax', 'Email', 'Ghi'
    ];

    public $timestamps = false;

    public function NhaCungCap1(){
        return $this->belongsTo('App\VatTu','MaNCC');
    }

}
