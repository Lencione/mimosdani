<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
});

// if (App::environment('production')) {
//     URL::forceScheme('https');
// }


Route::name('site.')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/contador', [HomeController::class, 'counter'])->name('counter');
    Route::post('/contadorclick', [HomeController::class, 'clickCounter'])->name('clickCounter');
    Route::post('/contact', [HomeController::class, 'contact'])->name('contact');
});

Auth::routes([
    'register' => false,
    'password.request' => false,
    'password.email' => false,
    'password.reset' => false,
]);

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('categorias/')->name('category.')->group(function(){
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::put('/edit/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('get/all', [CategoryController::class, 'getAll'])->name('getAll');
        Route::get('/get/{id}', [CategoryController::class, 'show'])->name('show');
    });

    Route::prefix('produtos/')->name('product.')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::post('/edit/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('get/all', [ProductController::class, 'getAll'])->name('getAll');
        Route::get('/get/{id}', [ProductController::class, 'show'])->name('show');

        Route::prefix('{id}/images/')->name('images.')->group(function(){
            Route::get('/get/all',[ImageController::class, 'getAll'])->name('getAll');
            Route::post('/upload', [ImageController::class, 'upload'])->name('upload');
            Route::delete('/destroy/{image}', [ImageController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('mensagens/')->name('message.')->group(function(){
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/getAll', [MessageController::class, 'getAll'])->name('getAll');
        Route::get('/get/{id}', [MessageController::class, 'get'])->name('get');
    });

    


});
