<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    protected $table = 'phan_quyen';

    protected $fillable = [
        'TenQuyen'
    ];

    public $timestamps = false;

}
