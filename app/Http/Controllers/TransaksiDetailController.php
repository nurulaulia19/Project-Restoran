<?php

namespace App\Http\Controllers;

use App\Models\DataProduk;
use App\Models\TransaksiDetailAditional;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransaksiDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id_transaksi_detail)
    {
        $dataProduk = DataProduk::all();
        $dataTransaksiDetail = TransaksiDetail::where('id_transaksi_detail', $id_transaksi_detail)->first();
        return view('transaksi.update', compact('dataTransaksiDetail','dataProduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_transaksi_detail)
    {
        DB::table('transaksi_detail')->where('id_transaksi_detail', $id_transaksi_detail)->update([
            'jumlah_produk' => $request->jumlah_produk,
            'created_at' => now(),
            'updated_at' => now()
    ]);

    return back()->with('success', 'Transaksi Detail edited successfully');

    // return redirect()->route('transaksi.create')->with('success', 'Transaksi Detail edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_transaksi_detail)
    {
        $dataTransaksiDetail = TransaksiDetail::where('id_transaksi_detail', $id_transaksi_detail);
        $dataTransaksiDetail->delete();
        $tda = TransaksiDetailAditional::where('id_transaksi_detail', $id_transaksi_detail);
        $tda->delete();
        return back()->with('success', 'Transaction updated successfully.');
    }
}
