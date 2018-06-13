<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected  $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'MaNV'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function phanQuyen(){
        return $this->belongsTo('App\PhanQuyen','MaQuyen', 'MaQuyen');
    }

    public function nhanVien(){
        return $this->belongsTo('App\NhanVien','MaNV','MaNV');
    }
}
