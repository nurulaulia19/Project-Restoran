<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\DataProduk;

use App\Models\DataUser;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\DataProduk;
use Illuminate\Http\Request;
use App\Models\AditionalProduk;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiDetailAditional;

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
        // $dataProduk = DataProduk::all();
        $dataKategori = Kategori::all(); 
        $dataTransaksi = Transaksi::with('produk')->get();
        $dataProduk = DataProduk::with('kategori', 'aditionalProduk')->get();
        $dataAditional = AditionalProduk::all();
        $dataTransaksiDetail = TransaksiDetail::where('id_transaksi', NULL)->with('transaksiDetailAditional', 'AditionalProduk', 'transaksi')->get();
        // dd($dataTransaksiDetail);
        // dd($dataProduk);
        
        $dataUser = DataUser::all();
    //     $selectedKategoriId = $request->input('filterKategori');

    // // Jika kategori dipilih, ambil produk berdasarkan ID kategori
    // if ($selectedKategoriId) {
    //     $dataProduk = DataProduk::where('id_kategori', $selectedKategoriId)->get();
    // }
        
        // $dataTransaksiDetail = TransaksiDetail::with('produk')->get();
        return view('transaksi.create', compact('dataTransaksi','dataUser', 'dataProduk', 'dataAditional','dataTransaksiDetail','dataKategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function storeTransaksi(Request $request){
    

    $totalHargaSetelahDiskon = $request->input('total_harga');
    $totalHargaSetelahDiskon = str_replace(['.', ','], '', $totalHargaSetelahDiskon);
    $totalKembalianInput  = $request->input('total_kembalian');
    $totalKembalianInput  = str_replace(['.', ','], '', $totalKembalianInput );
    $totalBayarInput   = $request->input('total_bayar');
    $totalBayarInput   = str_replace(['.', ','], '', $totalBayarInput  );
    
    $existingTransaksiDetails = TransaksiDetail::whereNull('id_transaksi')->get();
    $user_id = Auth::id();
    $dataTransaksi = Transaksi::create([
        'user_id' => $user_id,
        'tanggal_transaksi' => $request->tanggal_transaksi,
        'no_meja' => $request->no_meja,
        'total_harga' => $totalHargaSetelahDiskon,
        'total_bayar' => $totalBayarInput,
        'total_kembalian' => $totalKembalianInput,
        'ket_makanan' => $request->ket_makanan,
        'diskon_transaksi' => $request->diskon_transaksi,
    ]);

    foreach ($existingTransaksiDetails as $existingTransaksiDetail) {
        // Update the id_transaksi on each TransaksiDetail
        $existingTransaksiDetail->update([
            'id_transaksi' => $dataTransaksi->id_transaksi
        ]);
    }
    // session(['id_transaksi_baru' => $dataTransaksi->id_transaksi]);

    $request->session()->forget('id_transaksi_baru');

    return redirect()->route('transaksi.index')->with('success', 'Pembayaran berhasil disimpan.');

}



public function store(Request $request)
{
    $produk = DataProduk::find($request->id_produk);

    // Mengecek apakah data produk berhasil ditemukan
    if ($produk) {
        // $id_transaksi_baru = session('id_transaksi_baru');
        // Buat TransaksiDetail dan gunakan nilai harga_produk dan diskon_produk dari produk tersebut
        $transaksiDetail = TransaksiDetail::create([
            'id_transaksi' => $request->id_transaksi,
            // 'id_transaksi' => $id_transaksi_baru,
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
                    // 'id_transaksi' => $request->id_transaksi,
                    'id_transaksi_detail' => $transaksiDetail->id_transaksi_detail,
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
    return redirect()->route('')->with('success', 'Pembayaran berhasil disimpan.');
    }
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
    public function edit($id_transaksi)
        {
            $dataKategori = Kategori::all(); 
            $dataProduk = DataProduk::all();
            $dataTransaksiDetail = TransaksiDetail::where('id_transaksi', $id_transaksi)->get(); // Add a semicolon at the end of this line
            $dataTransaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
            return view('transaksi.update', compact('dataTransaksiDetail','dataProduk','dataTransaksi','dataKategori'));
        }


    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, $id_transaksi){
        $totalHargaSetelahDiskon = $request->input('total_harga');
        $totalHargaSetelahDiskon = str_replace(['.', ','], '', $totalHargaSetelahDiskon);
        $totalKembalianInput  = $request->input('total_kembalian');
        $totalKembalianInput  = str_replace(['.', ','], '', $totalKembalianInput );
        $totalBayarInput   = $request->input('total_bayar');
        $totalBayarInput   = str_replace(['.', ','], '', $totalBayarInput  );

        DB::table('transaksi')->where('id_transaksi', $id_transaksi)->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'no_meja' => $request->no_meja,
            'total_harga' => $totalHargaSetelahDiskon,
            'total_bayar' => $totalBayarInput,
            'total_kembalian' => $totalKembalianInput,
            'ket_makanan' => $request->ket_makanan,
            'diskon_transaksi' => $request->diskon_transaksi,
            'created_at' => now(),
            'updated_at' => now()
    ]);
    return redirect()->route('transaksi.index')->with('success', 'Menu edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_transaksi)
{
    // Find the transaction data based on ID
    $dataTransaksi = Transaksi::findOrFail($id_transaksi);

    // Check if transaction details exist before attempting to delete them
    if ($dataTransaksi->transaksiDetail) {
        foreach ($dataTransaksi->transaksiDetail as $transaksiDetail) {
            // Check if transaksiDetailAditional relation exists before attempting to delete it
            if ($transaksiDetail->transaksiDetailAditional) {
                $transaksiDetail->transaksiDetailAditional()->delete();
            }
        }
        // Delete transaction details
        $dataTransaksi->transaksiDetail()->delete();
    }

    // Delete the transaction itself
    $dataTransaksi->delete();

    return redirect()->route('transaksi.index')->with('success', 'Terdelet');
}

}
