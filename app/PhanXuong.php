<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhanXuong extends Model
{
    protected $table = 'phan_xuong';

    protected $primaryKey = 'MaPX';

    protected $fillable = [
        'MaPX', 'TenPX', 'GhiChu'
    ];
    public $incrementing = false;

    public $timestamps = false;
}
