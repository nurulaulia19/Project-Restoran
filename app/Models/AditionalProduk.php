<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AditionalProduk extends Model
{
    use HasFactory;
    public $table = "aditional_produk";
    protected $fillable = [
            'id_aditional',
            'id_produk',
            'nama_aditional',
            'harga_aditional',
    ];

    public function produk()
    {
        return $this->belongsTo(DataProduk::class, 'id_produk', 'id_produk');
    }

    public function aditional()
    {
        return $this->belongsTo(AditionalProduk::class, 'id_produk', 'id_produk');
    }

    // public function roleMenus()
    // {
    //     return $this->hasMany(RoleMenu::class, 'menu_id', 'menu_id');
    // }

    public function transaksiDetailAditional()
    {
        return $this->hasMany(TransaksiDetailAditional::class, 'id_aditional', 'id_aditional');
    }

    // public function transaksi()
    // {
    //     return $this->belongsTo(Tr::class, 'id_produk', 'id_produk');
    // }
}
