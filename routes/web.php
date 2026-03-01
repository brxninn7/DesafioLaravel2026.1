<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produto/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/address', [ProfileController::class, 'storeAddress'])->name('address.store');
    Route::delete('/profile/address/{address}', [ProfileController::class, 'destroyAddress'])->name('address.destroy');

    Route::get('admin/produtos/novo', [ProductController::class, 'create'])->name('products.create');
    Route::post('admin/produtos/salvar', [ProductController::class, 'store'])->name('products.store');
    Route::delete('admin/produtos/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin/users');
    Route::get('/admin/users/show/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/admin/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/destroy/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');

    Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');

    Route::get('/admin/administradores', [AdminController::class, 'admins'])->name('admin.admins.index');
    Route::post('/admin/admins/toggle/{id}', [AdminController::class, 'toggleAdmin'])->name('admin.admins.toggle');

    Route::get('/compras/baixar-pdf', [OrderController::class, 'exportPdf'])->middleware('auth')->name('orders.pdf');

    Route::get('/admin/historico-vendas', [AdminController::class, 'salesHistory'])->name('admin.sales.index');

    Route::post('/admin/users/{id}/send-email', [AdminController::class, 'sendEmailToUser'])->name('admin.users.email');
});

    Route::get('/api/cep/{cep}', function ($cep) {
        $cep = preg_replace('/\D/', '', $cep);
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        return $response->json();
    })->name('api.cep');

require __DIR__.'/auth.php';
