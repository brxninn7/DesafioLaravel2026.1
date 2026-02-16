<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/produto/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/produto', function (){
    return view('pagina-individual');
});

Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin/dashboard');
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin/users');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('admin/produtos/novo', [ProductController::class, 'create'])->name('products.create');
    Route::post('admin/produtos/salvar', [ProductController::class, 'store'])->name('products.store');
    Route::delete('admin/produtos/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::get('/cep/{cep}', function ($cep) {

    $cep = preg_replace('/\D/', '', $cep);

    $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

    return $response->json();
})->name('api.cep');

require __DIR__.'/auth.php';
