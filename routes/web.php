<?php

use App\Models\RoleMenu;
use App\Mail\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AditionalProduk;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataProdukController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TransaksiDetailAditional;
use App\Http\Controllers\TransaksiDetailController;
use App\Http\Controllers\AditionalProdukController;
use App\Http\Controllers\DataTokoController;
use App\Http\Controllers\PrintController;
use App\Models\TransaksiDetail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/admin/dashboard', function () {
//     return view('dashboard');
// });
Route::get('/admin/dashboard2', function () {
    return view('admin/dashboard2');
});
Route::get('/admin/dashboard3', function () {
    return view('admin/dashboard3');
});

Route::get('/admin/user', function () {
    return view('admin/user');
});

Route::get('/admin/transaksi/modal', function () {
    return view('transaksi/modal');
});

// Route::get('menu.update', function () {
//     return view('menu/update');
// });




Auth::routes();

Auth::routes([
    'verify' =>true
]);
Route::get('logout', [LoginController::class, 'logout']);
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('Adminlogin');
Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('Adminregister');
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');
// Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home')->middleware('verified');
Route::get('logout', [LoginController::class, 'showRegisterForm']);
Route::get('/admin/user', [App\Http\Controllers\MenuController::class, 'user'])->name('user');
Route::get('/admin/role', [App\Http\Controllers\MenuController::class, 'role'])->name('role');
Route::get('/admin/user', function () {
    return view('user');
});
Route::get('/admin/role', function () {
    return view('role');
});

Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu/store', [MenuController::class, 'store']);
Route::get('/admin/menu', [MenuController::class,'index'])->name('menu');
Route::get('/admin/menu/destroy/{id}', [MenuController::class,'destroy'])->name('menu.destroy');
Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::put('/admin/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
Route::get('/admin/role/create', [RoleController::class, 'create'])->name('role.create');
Route::get('/admin/role', [RoleController::class,'index'])->name('role');
Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::post('/role/store', [RoleController::class, 'store']);
Route::get('/admin/role/destroy/{id}', [RoleController::class,'destroy'])->name('role.destroy');
Route::put('/admin/user/update/{id}', [DataUserController::class, 'update'])->name('user.update');
Route::get('/admin/user/create', [DataUserController::class, 'create'])->name('user.create');
Route::get('/admin/user', [DataUserController::class,'index'])->name('user');
Route::get('/admin/user/edit/{id}', [DataUserController::class, 'edit'])->name('user.edit');
Route::post('/user/store', [DataUserController::class, 'store']);
Route::get('/admin/user/destroy/{id}', [DataUserController::class,'destroy'])->name('user.destroy');


// Route::post('/admin/transaksi/update/{id_transaksi}', [TransaksiController::class, 'updateTransaksiDetail'])->name('transaksi.update');

// Route::post('admin/transaksi/update', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::post('/admin/transaksi/update', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::get('/admin/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::get('/admin/transaksi', [TransaksiController::class,'index'])->name('transaksi.index');
Route::get('/admin/transaksi/edit/{id}', [TransaksiController::class, 'edit'])->name('transaksi.edit');
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::post('/transaksi/storeTransaksi', [TransaksiController::class, 'storeTransaksi'])->name('transaksi.storeTransaksi');


Route::post('/transaksi/updateTransaksi', [TransaksiController::class, 'updateTransaksi'])->name('transaksi.updateTransaksi');


Route::get('/admin/transaksi/destroy/{id}', [TransaksiController::class,'destroy'])->name('transaksi.destroy');
// Route::get('/admin/transaksi/destroy/{id}', [TransaksiController::class,'destroy'])->name('transaksi.destroy');

Route::post('/produk/search', [TransaksiController::class,'searchProducts'])->name('produk.search');
Route::post('/produk/search/{id_transaksi}', [TransaksiController::class,'search'])->name('produk.searchEdit');
// Route::post('/produk/search', [TransaksiController::class,'searchProductsEdit'])->name('produk.searchEdit');
Route::get('/produk/filter', [TransaksiController::class,'filter'])->name('produk.filter');
Route::post('/produk/filter/{id_transaksi}', [TransaksiController::class,'filterProducts'])->name('transaksi.filter');


// Route::get('/print/{id_transaksi?}', [PrintController::class,'print'])->name('print');
Route::get('/admin/transaksi/{id_transaksi}/resi', [TransaksiController::class, 'showReceipt'])->name('transaksi.resi');


Route::get('/admin/toko', [DataTokoController::class,'index'])->name('toko.index');
Route::put('/admin/toko/update/{id}', [DataTokoController::class, 'update'])->name('toko.update');
Route::get('/admin/toko/create', [DataTokoController::class, 'create'])->name('toko.create');
Route::post('/toko/store', [DataTokoController::class, 'store'])->name('toko.store');
Route::get('/admin/toko/edit/{id}', [DataTokoController::class, 'edit'])->name('toko.edit');
Route::get('/admin/toko/destroy/{id}', [DataTokoController::class,'destroy'])->name('toko.destroy');

Route::put('/admin/produk/update/{id}', [DataProdukController::class, 'update'])->name('produk.update');
Route::get('/admin/produk/create', [DataProdukController::class, 'create'])->name('produk.create');
Route::get('/admin/produk', [DataProdukController::class,'index'])->name('produk.index');
Route::get('/admin/produk/edit/{id}', [DataProdukController::class, 'edit'])->name('produk.edit');
Route::post('/produk/store', [DataProdukController::class, 'store']);
Route::get('/admin/produk/destroy/{id}', [DataProdukController::class,'destroy'])->name('produk.destroy');

Route::put('/admin/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::get('/admin/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::get('/admin/kategori', [KategoriController::class,'index'])->name('kategori.index');
Route::get('/admin/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::post('/kategori/store', [KategoriController::class, 'store']);
Route::get('/admin/kategori/destroy/{id}', [KategoriController::class,'destroy'])->name('kategori.destroy');

Route::put('/admin/aditional/update/{id}', [AditionalProdukController::class, 'update'])->name('aditional.update');
Route::get('/admin/aditional/create', [AditionalProdukController::class, 'create'])->name('aditional.create');
Route::get('/admin/aditional', [AditionalProdukController::class,'index'])->name('aditional.index');
Route::get('/admin/aditional/edit/{id}', [AditionalProdukController::class, 'edit'])->name('aditional.edit');
Route::post('/aditional/store', [AditionalProdukController::class, 'store']);
Route::get('/admin/aditional/destroy/{id}', [AditionalProdukController::class,'destroy'])->name('aditional.destroy');


// Route::post('/save-transaction-details', [TransaksiDetailController::class, 'saveTransactionDetails']);
Route::get('/admin/transaksidetail/destroy/{id}', [TransaksiDetailController::class,'destroy'])->name('transaksidetail.destroy');
Route::put('/admin/transaksidetail/update/{id}', [TransaksiDetailController::class, 'update'])->name('transaksidetail.update');
Route::get('/admin/transaksidetail/edit/{id}', [TransaksiDetailController::class, 'edit'])->name('transaksidetail.edit');

// routes/web.php
Route::get('/transactions', [TransaksiController::class, 'showTransactions']);


