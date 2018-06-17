<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnChiTietKhoVatTuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_kho_vat_tu', function (Blueprint $table) {
            $table->integer('SoLuongHong');
            $table->integer('TongSoLuong');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chi_tiet_kho_vat_tu', function (Blueprint $table) {
            //
        });
    }
}
