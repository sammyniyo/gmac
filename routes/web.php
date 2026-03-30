<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\FrontendController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    Route::get('/', [FrontendController::class, 'index'])->name('home');
    Route::get('/history', [FrontendController::class, 'history'])->name('history');
    Route::get('/products', [FrontendController::class, 'products'])->name('products');
    Route::get('/products/{product:slug}', [FrontendController::class, 'productDetail'])->name('products.show');
    Route::get('/news', [FrontendController::class, 'news'])->name('news');
    Route::get('/news/{post:slug}', [FrontendController::class, 'newsDetail'])->name('news.show');
    Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
    Route::get('/washing-stations', [FrontendController::class, 'stations'])->name('stations');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::post('/contact/send', [FrontendController::class, 'sendContact'])->name('contact.send');
});
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('product-categories', \App\Http\Controllers\Admin\ProductCategoryController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('news', \App\Http\Controllers\Admin\NewsPostController::class);
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryItemController::class);
    Route::resource('washing-stations', \App\Http\Controllers\Admin\WashingStationController::class);
    Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show', 'destroy']);
    Route::resource('subscribers', \App\Http\Controllers\Admin\SubscriberController::class)->only(['index', 'destroy']);
    Route::resource('statistics', \App\Http\Controllers\Admin\StatisticController::class)->except(['show']);
    
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
});

require __DIR__.'/auth.php';
