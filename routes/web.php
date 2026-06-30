<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\WarungController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('pages.auth.loginadmin');
});

Route::middleware(['auth'])->group(function () {
    // Route::get('home', function () {
    //     return view('pages.dashboard');
    // })->name('home');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home');
    Route::post('/pdfpenjualan', [App\Http\Controllers\HomeController::class, 'lihatpdf']);

    Route::resource('user', UserController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('meja', MejaController::class);
    Route::get('/transaksi', [App\Http\Controllers\PembayaranController::class, 'transaksi']);
    Route::get('/pesananmasuk', [App\Http\Controllers\PembayaranController::class, 'pesananmasuk']);
    Route::get('/allpesanan', [App\Http\Controllers\PembayaranController::class, 'allpesanan'])->name('allpesanan');
    Route::get('/pesananmasuk/update/{id}', [App\Http\Controllers\PembayaranController::class, 'updatepesananmasuk']);
    Route::get('/lapwarunglaris', [App\Http\Controllers\HomeController::class, 'lapwarunglaris']);
    Route::get('/lapproduklaris', [App\Http\Controllers\HomeController::class, 'lapproduklaris']);
    Route::get('/pembayaran/{id}/nota', [App\Http\Controllers\PembayaranController::class, 'nota'])->name('pembayaran.nota');

    Route::get('/keranjang/allproduk', [App\Http\Controllers\KeranjangController::class, 'createpenjualan']);
    Route::get('/pembayaran/allpembayaran', [App\Http\Controllers\PembayaranController::class, 'index'])->name('pembayaran.all');

    Route::get('/cart', [KeranjangController::class, 'index'])->name('cart');
    Route::post('/cart/add', [KeranjangController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [KeranjangController::class, 'update'])->name('cart.update');
    Route::get('/cart/remove/{id}', [KeranjangController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [KeranjangController::class, 'checkout'])->name('cart.checkout');

    Route::get('/checkout', [PembayaranController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [PembayaranController::class, 'processCheckout'])->name('checkout.process');

    Route::post('/checkout/create-order',[PembayaranController::class,'createOrder'])->name('checkout.create-order');
    Route::get('/pembayaran/{id}/invoice', [PembayaranController::class, 'invoice'])->name('pembayaran.invoice');

    Route::post('/midtrans/callback', [PembayaranController::class, 'callback']);

    Route::post('/pesanan/upload/{id}', [PembayaranController::class, 'uploadBukti'])->name('pesanan.upload');

    Route::get('/status-pesanan', [App\Http\Controllers\PesananController::class, 'status'])->name('pesanan.status');
});
