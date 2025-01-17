<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CAtegoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[AuthController::class,'login']);
Route::post('login',[AuthController::class,'AuthLogin']);
Route::get('logout',[AuthController::class,'logout']);


Route::group(['middleware' => 'admin'],function(){

    Route::get('admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

Route::get('/categories/index',[CAtegoryController::class,'index'])->name('categories.index');
Route::get('/categories/create',[CAtegoryController::class,'create'])->name('categories.create');
Route::post('/categories/store',[CAtegoryController::class,'store'])->name('categories.store');

Route::get('/categories/{id}/edit',[CAtegoryController::class,'edit'])->name('categories.edit');
Route::delete('/categories/destroy/{id}',[CAtegoryController::class,'destroy'])->name('categories.destroy');

