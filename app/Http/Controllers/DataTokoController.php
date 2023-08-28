<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\DataToko;
use App\Models\DataUser;
use App\Models\Data_Menu;
use App\Models\RoleMenu;
use Illuminate\Http\Request;

class DataTokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataToko = DataToko::orderBy('id_toko', 'ASC')->paginate(10);
        // $dataToko = DataToko::all();

        $user_id = auth()->user()->user_id;
        $user = DataUser::findOrFail($user_id);
        $menu_ids = $user->role->roleMenus->pluck('menu_id');
        
        $menu_route_name = request()->route()->getName(); // Nama route dari URL yang diminta
        
        // Ambil menu berdasarkan menu_link yang sesuai dengan nama route
        $requested_menu = Data_Menu::where('menu_link', $menu_route_name)->first();
        // dd($requested_menu);
        
        // Periksa izin akses berdasarkan menu_id dan user_id
        if (!$requested_menu || !$menu_ids->contains($requested_menu->menu_id)) {
            return redirect()->back()->with('error', 'You do not have permission to access this menu.');
        }


        $mainMenus = Data_Menu::where('menu_category', 'master menu')
            ->whereIn('menu_id', $menu_ids)
            ->get();

        $menuItemsWithSubmenus = [];

        foreach ($mainMenus as $mainMenu) {
            $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                ->where('menu_category', 'sub menu')
                ->whereIn('menu_id', $menu_ids)
                ->orderBy('menu_position')
                ->get();

            $menuItemsWithSubmenus[] = [
                'mainMenu' => $mainMenu,
                'subMenus' => $subMenus,
            ];
        }
        return view('toko.index', compact('dataToko','menuItemsWithSubmenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataToko = DataToko::all();

        $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'
        $user = DataUser::find($user_id);
        $role_id = $user->role_id;

        $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');

        $mainMenus = Data_Menu::where('menu_category', 'master menu')
            ->whereIn('menu_id', $menu_ids)
            ->get();

        $menuItemsWithSubmenus = [];

        foreach ($mainMenus as $mainMenu) {
            $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                ->where('menu_category', 'sub menu')
                ->whereIn('menu_id', $menu_ids)
                ->orderBy('menu_position')
                ->get();

            $menuItemsWithSubmenus[] = [
                'mainMenu' => $mainMenu,
                'subMenus' => $subMenus,
            ];
        }
        return view('toko.create', compact('dataToko','menuItemsWithSubmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'required|file|mimes:jpeg,jpg,png',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            // $fileName = $file->getClientOriginalName();
            $file->storeAs('public/photos', $fileName); 
        } else {
            $fileName = null;
        }

        $dataToko = new DataToko();
        $dataToko->id_toko = $request->id_toko;
        $dataToko->logo = $fileName;
        $dataToko->nama_toko = $request->nama_toko;
        $dataToko->no_hp = $request->no_hp;
        $dataToko->email = $request->email;
        $dataToko->alamat = $request->alamat;
        $dataToko->save();
    
        return redirect()->route('toko.index')->with('success', 'Data Toko inserted successfully');
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
    public function edit($id_toko)
    {
        $dataToko = DataToko::where('id_toko', $id_toko)->first();

        $user_id = auth()->user()->user_id; // Use 'user_id' instead of 'id'
        $user = DataUser::find($user_id);
        $role_id = $user->role_id;

        $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');

        $mainMenus = Data_Menu::where('menu_category', 'master menu')
            ->whereIn('menu_id', $menu_ids)
            ->get();

        $menuItemsWithSubmenus = [];

        foreach ($mainMenus as $mainMenu) {
            $subMenus = Data_Menu::where('menu_sub', $mainMenu->menu_id)
                ->where('menu_category', 'sub menu')
                ->whereIn('menu_id', $menu_ids)
                ->orderBy('menu_position')
                ->get();

            $menuItemsWithSubmenus[] = [
                'mainMenu' => $mainMenu,
                'subMenus' => $subMenus,
            ];
        }
        return view('toko.update', compact('dataToko','menuItemsWithSubmenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_toko)
    {
        $validator = Validator::make($request->all(), [
            'gambar_produk' => 'file|mimes:jpeg,jpg,png'
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $dataToko = DataToko::find($id_toko);
    
        if (!$dataToko) {
            // Produk dengan 'id_produk' yang dimaksud tidak ditemukan
            // Lakukan tindakan error handling atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'data toko tidak ditemukan.');
        }
    
        $dataToko->nama_toko = $request->nama_toko;
        $dataToko->no_hp = $request->no_hp;
        $dataToko->email = $request->email;
        $dataToko->alamat = $request->alamat;
    
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/photos', $fileName);
            $dataToko->logo = $fileName;
        }
    
        $dataToko->save();
    
        return redirect()->route('toko.index')->with('success', 'Data Toko berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_toko)
    {
        $dataToko = DataToko::where('id_toko', $id_toko);
        $dataToko->delete();
        return redirect()->route('toko.index')->with('success', 'Terdelet');
    }
}
