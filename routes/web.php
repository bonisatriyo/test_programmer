<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

// Mengarahkan '/' ke ProdukController untuk menampilkan produk
Route::get('/', [ProdukController::class, 'index']);

// Route untuk produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// Tambahan untuk mengambil produk
Route::get('/fetch-produk', [ProdukController::class, 'fetchProduk']);
