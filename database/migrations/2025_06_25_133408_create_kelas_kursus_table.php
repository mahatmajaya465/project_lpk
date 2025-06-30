<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelasKursusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas_kursus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('program_kursus_id', 225)->nullable();
            $table->string('kode_kelas', 225)->unique()->nullable();
            $table->string('nama_kelas', 225)->nullable();
            $table->dateTime('tgl_mulai')->nullable();
            $table->dateTime('tgl_selesai')->nullable();
            $table->dateTime('tgl_pendaftaran')->nullable();
            $table->dateTime('tgl_penutupan')->nullable();
            $table->string('jumlah_peserta', 225)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('status', 225)->default('active');
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
        Schema::dropIfExists('kelas_kursus');
    }
}
