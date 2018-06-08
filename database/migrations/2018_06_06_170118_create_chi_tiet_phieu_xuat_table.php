<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietPhieuXuatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_phieu_xuat', function (Blueprint $table) {
            $table->increments('id');
            $table->char('MaPhieuXuat');
            $table->char('MaVT');
            $table->integer('SoLuong');
            $table->integer('DonGia');
            $table->integer('ThanhTien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_phieu_xuat');
    }
}
