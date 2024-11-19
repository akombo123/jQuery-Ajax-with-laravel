<?php

use App\Http\Controllers\CAtegoryController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/categories/index',[CAtegoryController::class,'index'])->name('categories.index');
Route::get('/categories/create',[CAtegoryController::class,'create'])->name('categories.create');
Route::post('/categories/store',[CAtegoryController::class,'store'])->name('categories.store');

Route::get('/categories/{id}/edit',[CAtegoryController::class,'edit'])->name('categories.edit');
Route::delete('/categories/destroy/{id}',[CAtegoryController::class,'destroy'])->name('categories.destroy');

