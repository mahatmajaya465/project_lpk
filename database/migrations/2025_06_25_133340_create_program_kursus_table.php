<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramKursusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_kursus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_program', 225)->unique()->nullable();
            $table->string('nama_program', 225)->nullable();
            $table->string('harga', 225)->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('thumbnail')->nullable();
            $table->string('status', 225)->nullable();
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
        Schema::dropIfExists('program_kursus');
    }
}
