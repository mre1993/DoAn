<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietPhieuNhapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tieu_phieu_nhap', function (Blueprint $table) {
            $table->increments('ID');
            $table->char('MaPN');
            $table->char('MaVT');
            $table->integer('SoLuong');
            $table->integer('DonGia');
            $table->integer('ThanhTien');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tieu_phieu_nhap');
    }
}
