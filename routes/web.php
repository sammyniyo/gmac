<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'track.visitors']
], function() {
    Route::get('/', [FrontendController::class, 'index'])->name('home');
    Route::get('/history', [FrontendController::class, 'history'])->name('history');
    Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
    Route::get('/products', [FrontendController::class, 'products'])->name('products');
    Route::get('/products/{product:slug}', [FrontendController::class, 'productDetail'])->name('products.show');
    Route::get('/news', [FrontendController::class, 'news'])->name('news');
    Route::get('/news/{post:slug}', [FrontendController::class, 'newsDetail'])->name('news.show');
    Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
    Route::get('/washing-stations', [FrontendController::class, 'stations'])->name('stations');
    Route::get('/team', [FrontendController::class, 'team'])->name('team');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::post('/contact/send', [FrontendController::class, 'sendContact'])->name('contact.send');

    Route::get('/reviews', [FrontendController::class, 'reviews'])->name('reviews');
    Route::post('/reviews', [FrontendController::class, 'submitFeedback'])->name('reviews.submit');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product:slug}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{product:slug}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product:slug}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/thanks/{reference}', [CheckoutController::class, 'thanks'])->name('order.thanks');
});
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

Route::get('/dashboard', function () {
    if (auth()->user()?->is_admin) {
        return redirect()->route('admin.dashboard');
    }

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
    
    Route::resource('hero-slides', \App\Http\Controllers\Admin\HeroSlideController::class)->except(['show']);
    Route::resource('team-members', \App\Http\Controllers\Admin\TeamMemberController::class)->except(['show']);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);
    Route::resource('product-categories', \App\Http\Controllers\Admin\ProductCategoryController::class)->except(['show']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show']);
    Route::resource('news', \App\Http\Controllers\Admin\NewsPostController::class)->except(['show']);
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryItemController::class)->except(['show']);
    Route::resource('washing-stations', \App\Http\Controllers\Admin\WashingStationController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
    Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show', 'destroy']);
    Route::resource('feedbacks', \App\Http\Controllers\Admin\FeedbackController::class)->only(['index', 'destroy']);
    Route::post('feedbacks/{feedback}/approve', [\App\Http\Controllers\Admin\FeedbackController::class, 'approve'])->name('feedbacks.approve');
    Route::post('feedbacks/{feedback}/unapprove', [\App\Http\Controllers\Admin\FeedbackController::class, 'unapprove'])->name('feedbacks.unapprove');
    Route::resource('subscribers', \App\Http\Controllers\Admin\SubscriberController::class)->only(['index', 'destroy']);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::resource('statistics', \App\Http\Controllers\Admin\StatisticController::class)->except(['show']);
    
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
});

require __DIR__.'/auth.php';
