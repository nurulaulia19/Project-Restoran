<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\DataProduk;

use App\Models\AditionalProduk;
use App\Models\DataProduk;
use App\Models\DataUser;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $dataTransaksi = Transaksi::with('user')->get();
        return view('transaksi.index', compact('dataTransaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataTransaksi = Transaksi::with('produk')->get();
        $dataProduk = DataProduk::with('kategori', 'aditionalProduk')->get();
        $dataAditional = AditionalProduk::all();
        // dd($dataProduk);
        $dataUser = DataUser::all();
        return view('transaksi.create', compact('dataTransaksi','dataUser', 'dataProduk', 'dataAditional'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    // Validasi data dari form sebelum menyimpan ke database
    $request->validate([
        'user_id' => 'required|exists:data_user,id_user',
        'produk_id' => 'required|exists:data_produk,id_produk',
        'aditional_ids' => 'required|array',
        // Berikan validasi sesuai dengan kebutuhan data yang dibutuhkan
    ]);

    // Ambil data produk dari tabel data_produk
    $produk = DataProduk::findOrFail($request->produk_id);

    // Hitung total harga berdasarkan data produk dan jumlah yang diinginkan
    $jumlah_produk = 1; // Anda dapat mengganti nilainya berdasarkan input dari form
    $total_harga = $produk->harga_produk * $jumlah_produk;

    // Simpan data transaksi ke dalam tabel transaksi
    $transaksi = new Transaksi;
    $transaksi->user_id = $request->user_id;
    $transaksi->produk_id = $request->produk_id;
    $transaksi->jumlah_produk = $jumlah_produk;
    $transaksi->total_harga = $total_harga;

    // Anda juga dapat mengisi kolom-kolom lain sesuai dengan kolom yang telah ditentukan dalam tabel
    $transaksi->tanggal_transaksi = date('Y-m-d H:i:s'); // Contoh pengisian tanggal_transaksi dengan waktu saat ini
    $transaksi->no_meja = 'Nomor Meja XYZ'; // Contoh pengisian nomor meja
    $transaksi->total_bayar = 0; // Default total_bayar awalnya 0
    $transaksi->total_kembalian = 0; // Default total_kembalian awalnya 0
    $transaksi->ket_makanan = $request->keterangan; // Isi dengan keterangan dari form jika ada
    $transaksi->diskon_transaksi = 0; // Default diskon_transaksi awalnya 0

    $transaksi->save();

    // Jika ada opsi tambahan yang dipilih, simpan juga data opsi tambahan
    if ($request->has('aditional_ids')) {
        $aditionals = AditionalProduk::whereIn('id_aditional', $request->aditional_ids)->get();
        $transaksi->aditionals()->attach($aditionals);
    }

    // Setelah data tersimpan, Anda bisa melakukan redirect atau memberikan pesan sukses
    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
