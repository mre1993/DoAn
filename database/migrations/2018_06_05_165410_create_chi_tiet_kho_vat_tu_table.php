<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietKhoVatTuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_kho_vat_tu', function (Blueprint $table) {
            $table->increments('id');
            $table->char('MaKVT');
            $table->char('MaVT');
            $table->integer('SoLuongTon');
            $table->string('GhiChu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_kho_vat_tu');
    }
}
