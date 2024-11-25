<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');

    $res = Http::pool(fn(Pool $pool) => [
        $pool->as('products')->get($base . '/products'),
        $pool->as('populars')->get($base . '/popular-products'),
        $pool->as('categories')->get($base . '/product-category'),
    ]);

    $products = $res['products']->object();
    $populars = $res['populars']->object();
    $categories = $res['categories']->object();

    return view('landing', [
        'products' => $products->data,
        'populars' => $populars->data,
        'categories' => $categories->data,
    ]);
})->name('landing');


Route::get('/check', fn() => view('check'))->name('check');
Route::get('/privacy', fn() => view('privacy'))->name('privacy');
Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
Route::get('/messages', fn() => redirect('https://tawk.to/chat/607859d7067c2605c0c2c3a9/1f3b4dbk4'))->name('messages');

Route::prefix('cart')
    ->name('cart.')
    ->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');

        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/update', [CartController::class, 'update'])->name('update');

        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/confirm', [CartController::class, 'confirm'])->name('confirm');

        Route::post('/direct/confirm', [CartController::class, 'single'])->name('single');
        Route::get('/direct/{slug}', [CartController::class, 'direct'])->name('direct');
    });

Route::prefix('products')
    ->name('products.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
        Route::post('/like', [ProductController::class, 'like'])->name('like');
    });

Route::prefix('categories')
    ->name('categories.')
    ->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/{slug}', [CategoryController::class, 'show'])->name('show');
    });

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::get('/forgot', [AuthenticationController::class, 'forgot'])->name('forgot');
        Route::get('/change', [AuthenticationController::class, 'change'])->name('change');
        Route::get('/register', [AuthenticationController::class, 'register'])->name('register');

        Route::post('/login', [AuthenticationController::class, 'signin'])->name('signin');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
        Route::post('/register', [AuthenticationController::class, 'signup'])->name('signup');
        Route::post('/recovery', [AuthenticationController::class, 'recovery'])->name('recovery');
        Route::post('/reset', [AuthenticationController::class, 'reset'])->name('reset');
    });

Route::prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/setting', [ProfileController::class, 'setting'])->name('setting');

        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/password', [ProfileController::class, 'password'])->name('password');
    });


Route::prefix('orders')
    ->name('orders.')
    ->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::post('/payment', [OrderController::class, 'payment'])->name('payment');

        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
    });


Route::get('/whatsapp', function () {
    $phone = request()->get('phone');
    $text = request()->get('text');
    $url = 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . urlencode($text);
    return redirect($url);
})->name('whatsapp');

Route::post('/subscribe', function () {
    $email = request()->get('email');

    $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
    $res = Http::backend()->post($base . '/subscribe-news', [
        'email' => $email,
    ]);

    if ($res->successful()) session()->flash('success', 'Berhasil berlangganan!');
    else session()->flash('error', 'Gagal berlangganan!');

    return redirect()->back();
})->name('subscribe');
