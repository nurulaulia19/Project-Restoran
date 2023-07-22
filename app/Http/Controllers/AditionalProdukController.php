<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\AditionalProduk;
use App\Models\DataProduk;
use Illuminate\Http\Request;

class AditionalProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataAditional = AditionalProduk::with('produk')->get();
        return view('aditional.index', compact('dataAditional'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataProduk = DataProduk::all();
        $dataAditional = AditionalProduk::all();
        return view('aditional.create', compact('dataProduk','dataAditional'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataAditional = new AditionalProduk();
        $dataAditional->id_aditional = $request->id_aditional;
        $dataAditional->id_produk = $request->id_produk;
        $dataAditional->nama_aditional = $request->nama_aditional;
        $dataAditional->harga_aditional = $request->harga_aditional;
        $dataAditional->save();
    
        return redirect()->route('aditional.index')->with('success', 'Produk inserted successfully');


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
    public function edit($id_aditional)
    {
        $dataProduk = DataProduk::all();
        $dataAditional = AditionalProduk::where('id_aditional', $id_aditional)->first();
        return view('aditional.update', compact('dataProduk','dataAditional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_aditional)
    {
        DB::table('aditional_produk')->where('id_aditional', $id_aditional)->update([
            'id_produk' => $request->id_produk,
            'nama_aditional' => $request->nama_aditional,
            'harga_aditional' => $request->harga_aditional,
            'created_at' => now(),
            'updated_at' => now()
    ]);
    return redirect()->route('aditional.index')->with('success', 'Aditional edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_aditional)
    {
        $dataAditional = AditionalProduk::where('id_aditional', $id_aditional);
        $dataAditional->delete();
        return redirect()->route('aditional.index')->with('success', 'Terdelet');
    }
}
