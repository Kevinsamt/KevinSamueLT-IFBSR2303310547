<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiStockController;

// TODO: daftarkan route anda di sini

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Product Routes
Route::get('/barang', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/barang/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/barang', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/barang/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/barang/{produk}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/barang/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// Transaksi Stocks Routes
Route::get('/transaksi-stocks', [TransaksiStockController::class, 'index'])->name('transaksi-stocks.index');

require __DIR__.'/auth.php';
