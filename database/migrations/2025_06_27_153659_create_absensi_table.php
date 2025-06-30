<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id', 225)->nullable();
            $table->string('jadwal_id', 225)->nullable();
            $table->string('type', 225)->default('check_in');
            $table->string('tgl_absensi', 225)->nullable();
            $table->string('lat', 225)->nullable();
            $table->string('lng', 225)->nullable();
            $table->string('lokasi', 225)->nullable();
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
        Schema::dropIfExists('absensi');
    }
}
