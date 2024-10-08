<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerizinanKendaraan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perizinan_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->dateTime('keluar')->nullable();
            $table->dateTime('masuk')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('nomor')->nullable();
            $table->text('deskripsi')->nullable();
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
        Schema::dropIfExists('perizinan_kendaraan');
    }
}
