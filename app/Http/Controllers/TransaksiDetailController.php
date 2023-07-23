<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiDetail;
use App\Models\DataProduk;

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
        // $dataProduk = DataProduk::all();
        // $dataTransaskiDetail = TransaksiDetail::all();
        // return view('transaksi.create', compact('dataProduk', 'dataTransaskiDetail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $result = TransaksiDetail::insert([
            // 'id_transaksi_detail' => $request->id_transaksi_detail,
            // 'id_transaksi' => $request->id_transaksi,
            'id_produk' => $request->id_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'harga_produk' => $request->harga_produk,
            'diskon_produk' => $request->diskon_produk
        ]);
        if($result){
            return redirect()->route('transaksi.create')->with('success', 'Transaksi detail insert successfully');
        }else{
            return $this->create();
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
