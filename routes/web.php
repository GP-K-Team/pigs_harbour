<?php

declare(strict_types=1);

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PigsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);

Route::get('/ajax', [AjaxController::class, 'index']);

Route::prefix('pigs')->name('pigs.')->group(function () {
    Route::get('/', [PigsController::class, 'index'])->name('index');
    Route::get('/create', [PigsController::class, 'showCreate'])->name('show.create');
    Route::get('/update/{pig}', [PigsController::class, 'showUpdate'])->name('show.update');
    Route::get('/{pig}', [PigsController::class, 'showOne'])->name('one');
    Route::post('/', [PigsController::class, 'create'])->name('create');
    Route::post('/{pig}', [PigsController::class, 'update'])->name('update');
    Route::delete('/{pig}', [PigsController::class, 'delete'])->name('update');
});
