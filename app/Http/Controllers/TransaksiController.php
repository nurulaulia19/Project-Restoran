<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\DataProduk;

use App\Models\DataUser;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\DataProduk;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\AditionalProduk;
use App\Models\DataToko;
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
        
        $dataTransaksi = Transaksi::with('user')->orderBy('id_transaksi', 'DESC')->paginate(10);
        // $dataTransaksi = Transaksi::with('user')->get();
        return view('transaksi.index', compact('dataTransaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $dataKategori = Kategori::all(); 
        $dataTransaksi = Transaksi::with('produk')->get();
        $dataProduk = DataProduk::with('kategori', 'aditionalProduk')->get();



        $selectedKategoriId = $request->input('selectedKategori', null);

        // If a category is selected, filter the products by the selected category
        if ($selectedKategoriId) {
            $dataProduk = DataProduk::whereHas('kategori', function ($query) use ($selectedKategoriId) {
                $query->where('id_kategori', $selectedKategoriId);
            })->with('kategori', 'aditionalProduk')->get();
        } else {
            // If no category is selected, get all products
            $dataProduk = DataProduk::with('kategori', 'aditionalProduk')->get();
        }

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
        return view('transaksi.create', compact('dataTransaksi','dataUser','dataProduk','dataAditional','dataTransaksiDetail','dataKategori','selectedKategoriId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function storeTransaksi(Request $request){
    

    $totalHargaSetelahDiskon = $request->input('total_harga');
    $totalHargaSetelahDiskon = str_replace(['.', ','], '', $totalHargaSetelahDiskon); // phpcs:ignore ..DetectWeakValidation.Found
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
        'diskon_transaksi' => empty($request->diskon_transaksi) ? 0 : $request->diskon_transaksi,
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
        $transaksiDetail = TransaksiDetail::create([
            'id_transaksi' => $request->id_transaksi,
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

// pencarian
// public function searchProducts(Request $request)
// {
//     $keyword = $request->input('keyword');

//     // Query untuk mencari produk berdasarkan nama
//     $dataProduk = DataProduk::where('nama_produk', 'LIKE', "%$keyword%")
//         ->with('kategori', 'aditionalProduk')
//         ->get();

//     $dataKategori = Kategori::all();
    
//     $dataAditional = AditionalProduk::all();
//     $dataTransaksiDetail = TransaksiDetail::where('id_transaksi', NULL)
//         ->with('transaksiDetailAditional', 'AditionalProduk', 'transaksi')
//         ->get();
//     $dataUser = DataUser::all();

//     return view('transaksi.create', compact('dataProduk', 'dataKategori', 'dataAditional', 'dataTransaksiDetail', 'dataUser'));
// }

public function searchProducts(Request $request)
{
    $keyword = $request->input('keyword');
    $selectedKategoriId = $request->input('selectedKategori');

    // Query untuk mencari produk berdasarkan nama
    $dataProduk = DataProduk::where('nama_produk', 'LIKE', "%$keyword%")
        ->when($selectedKategoriId, function ($query) use ($selectedKategoriId) {
            // If a category is selected, filter the products by the selected category
            $query->whereHas('kategori', function ($subQuery) use ($selectedKategoriId) {
                $subQuery->where('id_kategori', $selectedKategoriId);
            });
        })
        ->with('kategori', 'aditionalProduk')
        ->get();

    $dataKategori = Kategori::all();
    $dataAditional = AditionalProduk::all();
    $dataTransaksiDetail = TransaksiDetail::where('id_transaksi', NULL)
        ->with('transaksiDetailAditional', 'AditionalProduk', 'transaksi')
        ->get();
    $dataUser = DataUser::all();

    
    return view('transaksi.create', compact('dataProduk', 'dataKategori', 'dataAditional', 'dataTransaksiDetail', 'dataUser', 'selectedKategoriId'));
}

public function search(Request $request, $id_transaksi)
    {
        $keyword = $request->input('keyword');
        $selectedKategoriId = $request->input('selectedKategori');

        // Query untuk mencari produk berdasarkan nama
        $dataProduk = DataProduk::where('nama_produk', 'LIKE', "%$keyword%")
            ->when($selectedKategoriId, function ($query) use ($selectedKategoriId) {
                // If a category is selected, filter the products by the selected category
                $query->whereHas('kategori', function ($subQuery) use ($selectedKategoriId) {
                    $subQuery->where('id_kategori', $selectedKategoriId);
                });
            })
            ->with('kategori', 'aditionalProduk')
            ->get();

        // Get other required data
        $dataKategori = Kategori::all();
        $dataAditional = AditionalProduk::all();
        $dataTransaksiDetail = TransaksiDetail::where('id_transaksi', $id_transaksi)
            ->with('transaksiDetailAditional', 'AditionalProduk', 'transaksi')
            ->get();
        $dataUser = DataUser::all();
        $dataTransaksi = Transaksi::find($request->id_transaksi);
       

        return view('transaksi.update', compact('dataProduk', 'dataKategori', 'dataAditional', 'dataTransaksiDetail', 'dataUser', 'selectedKategoriId','dataTransaksi'));
    }





public function filter(Request $request)
{
    $selectedKategori = $request->input('filterKategori');
    $request->session()->put('selectedKategori', $selectedKategori);
    return back();
    
    // $selectedKategori = $request->input('filterKategori');
    // return back()->with('selectedKategori', $selectedKategori);
    // return redirect()->route('transaksi.create', ['selectedKategori' => $selectedKategori]);
}


public function filterProducts(Request $request, $id_transaksi)
{
    $keyword = $request->input('keyword');
    $selectedKategoriId = $request->input('selectedKategori');

    // Query untuk mencari produk berdasarkan nama dan kategori
    $dataProduk = DataProduk::where('nama_produk', 'LIKE', "%$keyword%")
        ->when($selectedKategoriId, function ($query) use ($selectedKategoriId) {
            // If a category is selected, filter the products by the selected category
            $query->whereHas('kategori', function ($subQuery) use ($selectedKategoriId) {
                $subQuery->where('id_kategori', $selectedKategoriId);
            });
        })
        ->with('kategori', 'aditionalProduk')
        ->get();

    // Get other required data
    $dataKategori = Kategori::all();
    $dataAditional = AditionalProduk::all();
    $dataTransaksiDetail = TransaksiDetail::where('id_transaksi', $id_transaksi)
        ->with('transaksiDetailAditional', 'AditionalProduk', 'transaksi')
        ->get();
    $dataUser = DataUser::all();
    $dataTransaksi = Transaksi::find($request->id_transaksi);


    return view('transaksi.update', compact('dataProduk', 'dataKategori', 'dataAditional', 'dataTransaksiDetail', 'dataUser', 'selectedKategoriId','dataTransaksi'));
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
    public function edit(Request $request, $id_transaksi)
        {
            $dataKategori = Kategori::all(); 

            $selectedKategoriId = $request->session()->get('selectedKategori');
            // $selectedKategoriId = $request->input('selectedKategori');

        // If a category is selected, filter the products by the selected category
        $selectedKategoriId = $request->input('selectedKategori', null);

        // If a category is selected, filter the products by the selected category
        if ($selectedKategoriId) {
            $dataProduk = DataProduk::whereHas('kategori', function ($query) use ($selectedKategoriId) {
                $query->where('id_kategori', $selectedKategoriId);
            })->with('kategori', 'aditionalProduk')->get();
        } else {
            // If no category is selected, get all products
            $dataProduk = DataProduk::with('kategori', 'aditionalProduk')->get();
        }

        $dataAditional = AditionalProduk::all();
        $dataTransaksiDetail = TransaksiDetail::where('id_transaksi', NULL)->with('transaksiDetailAditional', 'AditionalProduk', 'transaksi')->get();


            // $dataProduk = DataProduk::all();
            $dataTransaksiDetail = TransaksiDetail::where('id_transaksi', $id_transaksi)->get(); // Add a semicolon at the end of this line
            $dataTransaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
            return view('transaksi.update', compact('dataTransaksiDetail','dataProduk','dataTransaksi','dataKategori','selectedKategoriId'));
        }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Update the transaction information
        // $request->validate([
        //     'tanggal_transaksi' => 'required|date',
        //     'no_meja' => 'required',
        //     'total_harga' => 'required|numeric',
        //     'total_bayar' => 'required|numeric',
        //     'total_kembalian' => 'required|numeric',
        //     'ket_makanan' => 'nullable',
        //     'diskon_transaksi' => 'nullable|numeric',
        // ]);
    
        // $totalHargaSetelahDiskon = str_replace(['.', ','], '', $request->input('total_harga'));
        // $totalKembalianInput = str_replace(['.', ','], '', $request->input('total_kembalian'));
        // $totalBayarInput = str_replace(['.', ','], '', $request->input('total_bayar'));
    
        // DB::table('transaksi')->where('id_transaksi', $id_transaksi)->update([
        //     'tanggal_transaksi' => $request->tanggal_transaksi,
        //     'no_meja' => $request->no_meja,
        //     'total_harga' => $totalHargaSetelahDiskon,
        //     'total_bayar' => $totalBayarInput,
        //     'total_kembalian' => $totalKembalianInput,
        //     'ket_makanan' => $request->ket_makanan,
        //     'diskon_transaksi' => $request->diskon_transaksi,
        //     'updated_at' => now()
        // ]);
    
        // Add new data to transaction details
        $produk = DataProduk::find($request->id_produk);
        if ($produk) {
            $transaksiDetail = TransaksiDetail::create([
                'id_transaksi' => $request->id_transaksi,
                'id_produk' => $request->id_produk,
                'jumlah_produk' => $request->jumlah_produk,
                'harga_produk' => $produk->harga_produk,
                'diskon_produk' => $produk->diskon_produk
            ]);
        } else {
            return back()->with('success', 'Menu edited successfully');


        }
    
        // Add new data to transaction additionals
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
        return back()->with('success', 'Menu edited successfully');


        // return back()->with('success', 'Menu edited successfully');


    }
    
    

     public function updateTransaksi(Request $request){
        $totalHargaSetelahDiskon = $request->input('total_harga');
        $totalHargaSetelahDiskon = str_replace(['.', ','], '', $totalHargaSetelahDiskon);
        $totalKembalianInput  = $request->input('total_kembalian');
        $totalKembalianInput  = str_replace(['.', ','], '', $totalKembalianInput );
        $totalBayarInput   = $request->input('total_bayar');
        $totalBayarInput   = str_replace(['.', ','], '', $totalBayarInput  );

        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'no_meja' => 'required',
            'total_harga' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'total_kembalian' => 'required|numeric',
            'ket_makanan' => 'nullable',
            'diskon_transaksi' => 'nullable|numeric',
        ]);
        DB::table('transaksi')->where('id_transaksi', $request->id_transaksi)->update([
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

public function showReceipt(Request $request)
{

    $dataToko = DataToko::all();
    $dataTransaksi = Transaksi::with('toko','produk','transaksiDetail','transaksiDetailAditional')->where('id_transaksi', $request->id_transaksi)->get();
    return view('transaksi.resi' , compact('dataTransaksi','dataToko'));
    
}

// public function showTransaksi(Request $request)
// {
//     $transaksi = Transaksi::find($request->id_transaksi); // Mengambil data transaksi berdasarkan ID

// // Hitung jumlah items (jumlah produk) berdasarkan data transaksi
// $jumlahItems = $transaksi->transaksiDetail->sum('jumlah_produk');

// // Tampilkan view dengan data transaksi dan jumlah items
// return view('transaksi.resi', [
//     'transaksi' => $transaksi,
//     'jumlahItems' => $jumlahItems
// ]);
// }


// public function showTransactions()
// {
//     // Mengambil data transaksi dan menggunakan metode paginate() untuk mengatur paging
//     $dataTransaksi = Transaksi::orderBy('id_transaksi', 'ASC')->paginate(10);

//     return view('transaksi.index', compact('dataTransaksi'));
// }

}

