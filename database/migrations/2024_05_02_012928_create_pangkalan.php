<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePangkalan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pangkalan', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable(true);
            $table->longText('deskripsi')->nullable(true);
            $table->longText('path')->comment('URL thumbnails')->nullable(true);
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
        Schema::dropIfExists('pangkalan');
    }
}
