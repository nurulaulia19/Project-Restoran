<?php

namespace App\Http\Controllers;

use App\Models\DataProduk;
use App\Models\DataToko;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function print()
    {
        // Replace 'print-view' with the name of the blade view you want to print
        // $dataTransaksi = Transaksi::all();
        $dataToko = DataToko::all();
        $dataProduk = DataProduk::all();
        // $dataTransaksi = Transaksi::with('toko','produk')->get();
        return view('transaksi.resi', compact('dataTransaksi','dataToko','dataProduk'));

    }

//     public function print($id_transaksi = null)
// {
//     if ($id_transaksi) {
//         // Find the transaction data by ID
//         $dataTransaksi = Transaksi::find($id_transaksi);

//         if (!$dataTransaksi) {
//             return back()->with('error', 'Transaction not found.');
//         }
//     } else {
//         // If no ID provided, get all transactions
//         $dataTransaksi = Transaksi::all();

//         if ($dataTransaksi->isEmpty()) {
//             return back()->with('error', 'No transactions found.');
//         }
//     }

//     return view('transaksi.resi', compact('dataTransaksi'));
// }
}
