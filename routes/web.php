<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Backend\PostController as BackendPostController;
use App\Http\Controllers\Backend\ProductController as BackendProductController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



// FRONTEND ROUTES (Public)
Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/blog', [FrontendPostController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [FrontendPostController::class, 'show'])->name('blog.show');
    Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [FrontendProductController::class, 'show'])->name('products.show');
});



Route::prefix('dashboard')->middleware(['auth'])->group(function() {
    
    // Dashboard utama
    Route::get('/', function () {
        return view('dashboard', [
            'users' => App\Models\User::count(),
            'posts' => App\Models\Post::count(),
            'products' => App\Models\Product::count(),
        ]);
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Posts (Backend)
    Route::resource('posts', BackendPostController::class);
    
    // CRUD Products (Backend)
    Route::resource('products', BackendProductController::class);

    // CRUD Users (khusus admin)
    Route::resource('users', BackendUserController::class)->middleware('can:admin-access');
});

require __DIR__.'/auth.php';
