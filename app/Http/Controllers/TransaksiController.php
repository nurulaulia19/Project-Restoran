<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\DataProduk;

use App\Models\DataUser;
use App\Models\Transaksi;
use App\Models\DataProduk;
use Illuminate\Http\Request;
use App\Models\TransaksiDetailAditional;
use App\Models\AditionalProduk;
use App\Models\TransaksiDetail;

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
        // $roles = Role::with('roleMenus')->get();
        $dataTransaksi = Transaksi::with('produk')->get();
        $dataProduk = DataProduk::with('kategori', 'aditionalProduk')->get();
        $dataAditional = AditionalProduk::all();
        $dataTransaksiDetail = TransaksiDetail::with('transaksiDetailAditional', 'AditionalProduk')->get();
        // dd($dataTransaksiDetail);
        // dd($dataProduk);
        $dataUser = DataUser::all();
        // $dataTransaksiDetail = TransaksiDetail::with('produk')->get();
        return view('transaksi.create', compact('dataTransaksi','dataUser', 'dataProduk', 'dataAditional','dataTransaksiDetail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    $produk = DataProduk::find($request->id_produk);

    // Mengecek apakah data produk berhasil ditemukan
    if ($produk) {
        // Buat TransaksiDetail dan gunakan nilai harga_produk dan diskon_produk dari produk tersebut
        $transaksiDetail = TransaksiDetail::create([
            'id_produk' => $request->id_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'harga_produk' => $produk->harga_produk,
            'diskon_produk' => $produk->diskon_produk
        ]);

    // Cek apakah ada aditional yang dipilih dalam request
    if ($request->has('id_aditional')) {
        // Ambil data aditional dari request
        $id_aditionals = $request->id_aditional;

        // Loop melalui data aditional dan simpan ke tabel TransaksiAditionalDetail
        foreach ($id_aditionals as $id_aditional) {
            // Mendapatkan data aditional berdasarkan id_aditional dari request
            $aditional = AditionalProduk::where('id_aditional', $id_aditional)->first();

            // Mengecek apakah data aditional berhasil ditemukan
            if ($aditional) {
                // Buat TransaksiAditionalDetail dan gunakan nilai yang sesuai
                TransaksiDetailAditional::create([
                    
                    'id_transaksi_detail' => $transaksiDetail->id,
                    'id_produk' => $request->id_produk,
                    'id_aditional' => $id_aditional,
                    'harga_aditional' => $aditional->harga_aditional,
                    // tambahkan atribut lainnya jika diperlukan
                ]);
            } else {
                return response()->json(['message' => 'Aditional tidak ditemukan'], 404);
            }
        }
    }

    // Berhasil menyimpan data
    return redirect()->route('transaksi.create')->with('success', 'Transaksi berhasil disimpan.');
} else {
    return response()->json(['message' => 'Produk tidak ditemukan'], 404);
}

        $dataTransaksi = new Transaksi();
        $dataTransaksi->user_id = $request->user_id;
        $dataTransaksi->tanggal_transaksi = $request->tanggal_transaksi;
        $dataTransaksi->no_meja = $request->no_meja;
        $dataTransaksi->total_harga = $request->total_harga;
        $dataTransaksi->total_bayar = $request->total_bayar;
        $dataTransaksi->total_kembalian = $request->total_kembalian;
        $dataTransaksi->ket_makanan = $request->ket_makanan;
        $dataTransaksi->diskon_transaksi = $request->diskon_transaksi;
        $dataTransaksi->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi inserted successfully');
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
