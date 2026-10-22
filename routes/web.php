
<?php

use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminBorrowingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Utama dan Detail Buku
|--------------------------------------------------------------------------
*/

Route::get('/', [BookController::class, 'index'])
    ->name('books.index');

Route::get('/buku/{book}', [BookController::class, 'show'])
    ->name('books.show');

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'registerForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Fitur User
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Keranjang
    Route::get('/keranjang', [BookController::class, 'cart'])
        ->name('cart.index');

    Route::post('/keranjang/{book}', [BookController::class, 'addToCart'])
        ->name('cart.add');

    Route::patch('/keranjang/{book}', [BookController::class, 'updateCart'])
        ->name('cart.update');

    Route::delete('/keranjang/{book}', [BookController::class, 'removeFromCart'])
        ->name('cart.remove');

    // Pengajuan peminjaman
    Route::get('/checkout', [BorrowingController::class, 'checkout'])
        ->name('checkout');

    Route::post('/peminjaman', [BorrowingController::class, 'store'])
        ->name('borrowings.store');

    // Riwayat peminjaman user
    Route::get('/peminjaman-saya', [BorrowingController::class, 'index'])
        ->name('borrowings.index');

    Route::get('/peminjaman-saya/{borrowing}', [BorrowingController::class, 'show'])
        ->name('borrowings.show');
});

/*
|--------------------------------------------------------------------------
| Panel Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Daftar seluruh peminjaman
        Route::get('/peminjaman', [AdminBorrowingController::class, 'index'])
            ->name('borrowings.index');

        // Setujui permohonan
        Route::post(
            '/peminjaman/{borrowing}/setujui',
            [AdminBorrowingController::class, 'approve']
        )->name('borrowings.approve');

        // Tolak permohonan
        Route::post(
            '/peminjaman/{borrowing}/tolak',
            [AdminBorrowingController::class, 'reject']
        )->name('borrowings.reject');

        // Catat pengembalian
        Route::post(
            '/peminjaman/{borrowing}/kembalikan',
            [AdminBorrowingController::class, 'markReturned']
        )->name('borrowings.return');

        // Hapus riwayat peminjaman
        Route::delete(
            '/peminjaman/{borrowing}',
            [AdminBorrowingController::class, 'destroy']
        )->name('borrowings.destroy');

        // Kelola buku
        Route::resource('buku', AdminBookController::class)
            ->names('books');
    });
