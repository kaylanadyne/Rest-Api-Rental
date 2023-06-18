<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat');
            $table->enum('type', ['1-4 orang' , '1-6 orang']);
            $table->integer('waktu_jam');
            $table->integer('total_harga');
            $table->string('jam_mulai');
            $table->string('supir');
            $table->string('jam_selesai')->nullable();
            $table->text('tempat_tujuan')->nullable();
            $table->text('riwayat_perjalanan')->nullable();
            $table->enum('status', ['proses' , 'selesai']);
            $table->softDeletes();
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
        Schema::dropIfExists('rental');
    }
};
