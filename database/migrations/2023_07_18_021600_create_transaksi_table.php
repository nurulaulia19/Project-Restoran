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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->integer('user_id');
            $table->date('tanggal_transaksi');
            $table->integer('no_meja');
            $table->integer('total_harga');
            $table->integer('total_bayar');
            $table->integer('total_kembalian');
            $table->enum('ket_makanan', ['dine in', 'take away']);
            $table->integer('diskon_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
