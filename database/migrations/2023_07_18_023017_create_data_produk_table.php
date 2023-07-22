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
        Schema::create('data_produk', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->integer('id_kategori');
            $table->string('nama_produk');
            $table->integer('harga_produk');
            $table->string('gambar_produk');
            $table->integer('diskon_produk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_produk');
    }
};
