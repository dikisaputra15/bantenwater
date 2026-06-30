<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->text('kode_pesanan');
            $table->date('tgl_pemesanan');
            $table->enum('status_pesanan', ['dipesan', 'dikirim', 'dalam perjalanan', 'selesai']);
            $table->enum('status_pembayaran', ['belum bayar', 'menunggu verifikasi', 'lunas']);
            $table->double('total');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
