<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetailAditional;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

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
    public function destroy($id_transaksi_detail)
    {
        $dataTransaksiDetail = TransaksiDetail::where('id_transaksi_detail', $id_transaksi_detail);
        $dataTransaksiDetail->delete();
        $tda = TransaksiDetailAditional::where('id_transaksi_detail', $id_transaksi_detail);
        $tda->delete();
        return redirect()->route('transaksi.create')->with('success', 'Terdelet');
    }
}
