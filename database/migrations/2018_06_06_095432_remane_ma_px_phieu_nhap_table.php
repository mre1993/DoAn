<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemaneMaPxPhieuNhapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phieu_nhap', function (Blueprint $table) {
            $table->renameColumn('MaKVT', 'MaPX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phieu_nhap', function (Blueprint $table) {
            $table->renameColumn('MaPX', 'MaKVT');
        });
    }
}
