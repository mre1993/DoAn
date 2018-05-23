<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVatTuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vat_tu', function (Blueprint $table) {
            $table->increments('id');
            $table->char('MaVT');
            $table->string('TenVT');
            $table->string('DVT');
            $table->char('MaNCC');
            $table->char('MaLoaiVT');
            $table->string('MoTa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vat_tu');
    }
}
