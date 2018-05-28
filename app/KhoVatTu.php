<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KhoVatTu extends Model
{
    protected $table = 'kho_vat_tu';

    protected $fillable = [
        'MaKVT', 'TenKVT', 'DiaChi', 'SDT', 'ThuKho', 'GhiChu', 'Fax'
    ];

    protected $primaryKey = "MaKVT";

    public $timestamps = false;

    public $incrementing = false;

}
