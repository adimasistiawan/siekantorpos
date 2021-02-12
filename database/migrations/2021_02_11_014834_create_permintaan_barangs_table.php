<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->date('tanggal_diminta');
            $table->date('tanggal_dipenuhi')->nullable();
            $table->integer('kantor_id');
            $table->integer('diminta_oleh');
            $table->integer('dipenuhi_oleh')->nullable();
            $table->string('status');
            $table->string('alasan_ditolak')->nullable();
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
        Schema::dropIfExists('permintaan_barangs');
    }
}
