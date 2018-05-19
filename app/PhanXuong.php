<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhanXuong extends Model
{
    protected $table = 'phan_xuong';

    protected $fillable = [
        'MaPX', 'TenPX', 'GhiChu'
    ];

    public $timestamps = false;
}
