<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    protected $table = 'loai_vat_tu';

    protected $primaryKey = 'MaLoaiVT';

    protected $fillable = [
        'MaLoaiVT', 'TenLoaiVT',
    ];

    public $incrementing = false;

    public $timestamps = false;

}
