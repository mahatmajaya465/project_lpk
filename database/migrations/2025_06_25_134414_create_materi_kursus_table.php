<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriKursusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materi_kursus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_materi', 225)->unique()->nullable();
            $table->string('nama', 225)->nullable();
            $table->string('deskripsi', 225)->nullable();
            $table->string('kategori', 225)->nullable();
            $table->string('silabus', 225)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materi_kursus');
    }
}
