<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKhoVatTuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kho_vat_tu', function (Blueprint $table) {
            $table->char('MaKVT');
            $table->string('TenKVT');
            $table->string('DiaChi');
            $table->string('SDT');
            $table->string('Fax')->nullable();
            $table->string('ThuKho')->nullable();
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
        Schema::dropIfExists('kho_vat_tu');
    }
}
