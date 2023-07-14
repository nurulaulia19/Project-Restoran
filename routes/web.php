<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCode;
use App\Models\RoleMenu;

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

// Route::get('menu.update', function () {
//     return view('menu/update');
// });




Auth::routes();

Auth::routes([
    'verify' =>true
]);

// Route::get('/login', [LoginController::class, 'login'])->name('login');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
Route::get('logout', [LoginController::class, 'logout']);
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('Adminlogin');
Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('Adminregister');
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home')->middleware('verified');
Route::get('logout', [LoginController::class, 'showRegisterForm']);
// Route::get('dashboard2', [LoginController::class, 'showRegisterForm']);
// Route::get('/verify-account', [App\Http\Controllers\HomeController::class, 'verifyaccount'])->name('verifyaccount');
// Route::post('/verifyotp', [App\Http\Controllers\HomeController::class, 'useractivation'])->name('verifyotp');

// Route::get('/admin/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu');
// Route::get('/admin/menu', [App\Http\Controllers\MenuController::class, 'update'])->name('menu.update');
// Route::get('/admin/menu', [App\Http\Controllers\MenuController::class, 'update'])->name('menu.update');
Route::get('/admin/user', [App\Http\Controllers\MenuController::class, 'user'])->name('user');
Route::get('/admin/role', [App\Http\Controllers\MenuController::class, 'role'])->name('role');
// Route::get('/menu/destroy/{id}', [MenuController::class,'destroy']);
// Route::get('/admin/menu', function () {
//     return view('menu');
// });
Route::get('/admin/user', function () {
    return view('user');
});
Route::get('/admin/role', function () {
    return view('role');
});


// CRUD
// Route::get('/mahasiswa', [mahasiswaController::class,'index']);
// Route::get('/mahasiswa/create', [mahasiswaController::class,'create']);
// Route::post('/mahasiswa/store', [mahasiswaController::class,'store']);
// Route::get('/mahasiswa/edit/{id}', [mahasiswaController::class,'edit']);
// Route::post('/mahasiswa/update/{id}', [mahasiswaController::class,'update']);
// Route::get('/mahasiswa/destroy/{id}', [mahasiswaController::class,'destroy']);
// Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu/store', [MenuController::class, 'store']);
// Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::get('/admin/menu', [MenuController::class,'index'])->name('menu');
// Route::get('/menu', [MenuController::class,'index'])->name('menu');
Route::get('/admin/menu/destroy/{id}', [MenuController::class,'destroy'])->name('menu.destroy');
// Route::get('/tampilkandata/{menu_id}', [MenuController::class, 'tampilkandata'])->name('tampilkandata');
// Route::get('/menu/edit/{id}', [MenuController::class,'edit'])->name('menu.edit');
Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');


// Route::get('/mahasiswa/edit/{id}', [mahasiswaController::class,'edit']);
// Route::post('/mahasiswa/update/{id}', [mahasiswaController::class,'update']);

// Route::post('/tampilkandata/{id}'), [MenuController::class,'destroy'] 

Route::put('/admin/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
Route::get('/admin/role/create', [RoleController::class, 'create'])->name('role.create');
Route::get('/admin/role', [RoleController::class,'index'])->name('role');
Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::post('/role/store', [RoleController::class, 'store']);
Route::get('/admin/role/destroy/{id}', [RoleController::class,'destroy'])->name('role.destroy');
// Route::get('/menu', [MenuController::class,'index'])->name('menu');
// Route::get('/admin/menu/destroy/{id}', [MenuController::class,'destroy'])->name('menu.destroy');
// // Route::get('/tampilkandata/{menu_id}', [MenuController::class, 'tampilkandata'])->name('tampilkandata');
// // Route::get('/menu/edit/{id}', [MenuController::class,'edit'])->name('menu.edit');
// Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
// Route::put('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');

Route::put('/admin/user/update/{id}', [DataUserController::class, 'update'])->name('user.update');
Route::get('/admin/user/create', [DataUserController::class, 'create'])->name('user.create');
Route::get('/admin/user', [DataUserController::class,'index'])->name('user');
Route::get('/admin/user/edit/{id}', [DataUserController::class, 'edit'])->name('user.edit');
Route::post('/user/store', [DataUserController::class, 'store']);
Route::get('/admin/user/destroy/{id}', [DataUserController::class,'destroy'])->name('user.destroy');