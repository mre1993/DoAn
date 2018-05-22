<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VatTu extends Model
{
    protected $table = 'vat_tu';

    protected $fillable = [
        'id', 'MaVT', 'TenVT', 'DVT', 'MaNCC', 'MaLoai', 'MoTa'
    ];

    public $timestamps = false;
}
