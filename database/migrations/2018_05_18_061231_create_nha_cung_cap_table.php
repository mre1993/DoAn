<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhaCungCapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nha_cung_cap', function (Blueprint $table) {
            $table->char('MaNCC');
            $table->string('TenNCC');
            $table->string('DiaChi');
            $table->string('SDT');
            $table->string('Fax')->nullable();
            $table->string('Email');
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
        Schema::dropIfExists('nha_cung_cap');
    }
}
