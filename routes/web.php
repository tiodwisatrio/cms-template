<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Backend\AboutController as BackendAboutController;
use App\Http\Controllers\Backend\OurClientController as BackendOurClientController;
use App\Http\Controllers\Backend\CategoryController as BackendCategoryController;
use App\Http\Controllers\Backend\ContactController as BackendContactController;
use App\Http\Controllers\Backend\PostController as BackendPostController;
use App\Http\Controllers\Backend\ProductController as BackendProductController;
use App\Http\Controllers\Backend\SettingController as BackendSettingController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Backend\WhyChooseUsController as BackendWhyChooseUsController;

use App\Http\Controllers\Frontend\AboutController as FrontendAboutController;
use App\Http\Controllers\Frontend\ContactController as FrontendContactController;
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
    Route::get('/abouts', [FrontendAboutController::class, 'index'])->name('abouts.index');
    Route::get('/contact', [FrontendContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [FrontendContactController::class, 'store'])->name('contact.store');
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

    // CRUD Categories (Backend)
    Route::resource('categories', BackendCategoryController::class);
    
        // CRUD Categories for Teams (Backend)
        Route::resource('team/categories', App\Http\Controllers\Backend\TeamCategoryController::class, ['as' => 'team.categories']);

    // CRUD Users (khusus admin)
    Route::resource('users', BackendUserController::class)->middleware('can:admin-access');
    
    // CRUD Abouts (Backend)
    Route::resource('abouts', BackendAboutController::class)->middleware('can:admin-access');

    // CRUD Services (Backend)
    Route::resource('services', \App\Http\Controllers\Backend\ServiceController::class)->middleware('can:admin-access');

    // CRUD Our Clients (Backend)
    Route::resource('ourclient', BackendOurClientController::class)->middleware('can:admin-access');

    // CRUD Our Values (Backend)
    Route::resource('ourvalues', \App\Http\Controllers\Backend\OurValueController::class)->middleware('can:admin-access');

    // CRUD Testimonials (Backend)
    Route::resource('testimonials', \App\Http\Controllers\Backend\TestimonialController::class)->middleware('can:admin-access');

    // CRUD Why Choose Us (Backend)
Route::resource('whychooseus', BackendWhyChooseUsController::class)
    ->parameters(['whychooseus' => 'whychooseus'])
    ->middleware('can:admin-access');    // CRUD Teams (Backend)
    Route::resource('teams', \App\Http\Controllers\Backend\TeamController::class)->middleware('can:admin-access');

    // Contact Messages
    Route::get('/contacts', [BackendContactController::class, 'index'])->name('contacts.index');
   
    Route::get('/contacts/{contact}', [BackendContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{contact}/reply', [BackendContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{contact}', [BackendContactController::class, 'destroy'])->name('contacts.destroy');

    // Settings
    Route::get('/settings/email', [BackendSettingController::class, 'emailSettings'])->name('settings.email')->middleware('can:admin-access');
    Route::post('/settings/email', [BackendSettingController::class, 'updateEmailSettings'])->name('settings.email.update')->middleware('can:admin-access');
    Route::post('/settings/email/test', [BackendSettingController::class, 'testEmail'])->name('settings.email.test')->middleware('can:admin-access');
});

require __DIR__.'/auth.php';
