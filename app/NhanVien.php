<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhan_vien';

    protected $fillable = [
        'MaNV', 'TenNV', 'SDT', 'GioiTinh', 'ChucVu'
    ];

    protected $primaryKey = "MaNV";

    public $timestamps = false;

    public $incrementing = false;
}
