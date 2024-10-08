<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerizinanRanpur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perizinan_ranpur', function (Blueprint $table) {
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
        Schema::dropIfExists('perizinan_ranpur');
    }
}
