<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_pembayaran')->unique()->nullable();
            $table->dateTime('tgl_pembayaran')->nullable();
            $table->string('pendaftaran_id', 225)->nullable();
            $table->string('nominal', 225)->nullable();
            $table->string('status', 225)->default('pending')->nullable();
            $table->text('bukti_pembayaran')->nullable();
            $table->string('metode_pembayaran', 225)->nullable();
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
        Schema::dropIfExists('pembayaran');
    }
}
