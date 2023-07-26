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
        Schema::create('transaksi_detail_aditional', function (Blueprint $table) {
            $table->increments('id_tda');
            $table->integer('id_transaksi_detail');
            $table->integer('id_produk');
            $table->integer('id_aditional');
            $table->integer('harga_aditional');
            $table->timestamps();


            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail_aditional');
    }
};
