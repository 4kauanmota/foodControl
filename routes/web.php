<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'ProductList'])->name('product.list');
    Route::get('/products/{product}/{replace}', [ProductController::class, 'update'])->name('product.replace');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [UserController::class, 'show'])->name('notifications');
    Route::get('/cancel/{notification}', [UserController::class, 'ReplaceCancel'])->name('replace.cancel');
    Route::get('/read/{notification}', [UserController::class, 'MarkAsRead'])->name('mark.read');
    Route::get('/accept/{notification}', [UserController::class, 'AcceptReplace'])->name('replace.accept');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// TESTE PARA O ENVIO DO EMAIL
Route::get('teste-email', function() {
    return new App\Mail\ProductReplaceMail('wendell','lucas','cama','televisão');
});

require __DIR__.'/auth.php';
