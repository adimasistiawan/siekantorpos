<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyesuaianStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyesuaian_stok', function (Blueprint $table) {
            $table->id();
            $table->integer('barang_id');
            $table->integer('user_id');
            $table->integer('stok_sistem');
            $table->integer('stok_aktual');
            $table->integer('selisih');
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
        Schema::dropIfExists('penyesuaian_stoks');
    }
}
