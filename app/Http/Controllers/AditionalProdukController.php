<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\AditionalProduk;
use App\Models\DataProduk;
use App\Models\Data_Menu;
use App\Models\DataUser;
use App\Models\RoleMenu;
use Illuminate\Http\Request;

class AditionalProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataAditional = AditionalProduk::with('produk')->orderBy('id_aditional', 'DESC')->paginate(10);
        // $dataAditional = AditionalProduk::with('produk')->get();

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
        return view('aditional.index', compact('dataAditional','menuItemsWithSubmenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataProduk = DataProduk::all();
        $dataAditional = AditionalProduk::all();

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
        return view('aditional.create', compact('dataProduk','dataAditional','menuItemsWithSubmenus'));
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
    
        return redirect()->route('aditional.index')->with('success', 'Aditional inserted successfully');


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
        return view('aditional.update', compact('dataProduk','dataAditional','menuItemsWithSubmenus'));
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
