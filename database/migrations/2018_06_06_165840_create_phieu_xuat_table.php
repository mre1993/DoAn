<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhieuXuatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phieu_xuat', function (Blueprint $table) {
            $table->char('MaPhieuXuat');
            $table->char('MaPX');
            $table->char('MaKVT');
            $table->char('MaNV');
            $table->string('NoiDung')->nullable();
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
        Schema::dropIfExists('phieu_xuat');
    }
}
