<?php

declare(strict_types=1);

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PageTextController;
use App\Http\Controllers\PigsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('home');

Route::get('/admin', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/ajax', [AjaxController::class, 'index']);

Route::middleware('auth:web')->get('/archive/{city?}/{sex?}/{age?}/{fur?}', [PigsController::class, 'archive'])->name('pigs.archive');

Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::middleware('auth:web')->group(function () {
        Route::get('/update/{pig}', [PigsController::class, 'showUpdate'])->name('show.update');
        Route::get('/create', [PigsController::class, 'showCreate'])->name('show.create');
        Route::post('/', [PigsController::class, 'create'])->name('create');
        Route::post('/{pig}', [PigsController::class, 'update'])->name('update');
        Route::delete('/{pig}', [PigsController::class, 'delete'])->name('update');
        Route::post('/status/{pig}', [PigsController::class, 'updateStatus'])->name('status');
    });

    Route::get('show/{pig}', [PigsController::class, 'showOne'])->name('one');
    Route::get('/{city?}/{sex?}/{age?}/{fur?}', [PigsController::class, 'index'])->name('index');
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::middleware('auth:web')->group(function () {
        Route::get('/create', [ArticlesController::class, 'showCreate'])->name('show.create');
        Route::get('/update/{article}', [ArticlesController::class, 'showUpdate'])->name('show.update');
        Route::post('/', [ArticlesController::class, 'create'])->name('create');
        Route::post('/{article}', [ArticlesController::class, 'update'])->name('update');
        Route::delete('/{article}', [ArticlesController::class, 'delete'])->name('delete');
    });

    Route::get('/', [ArticlesController::class, 'index'])->name('index');
    Route::get('/{article}', [ArticlesController::class, 'showOne'])->name('one');
});

Route::middleware('auth:web')->group(function () {
   Route::delete('files/{file}', [FileController::class, 'delete']);
   Route::put('page_text/{pageText}', [PageTextController::class, 'update']);
});
