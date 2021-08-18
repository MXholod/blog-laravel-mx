<?php

use Illuminate\Support\Facades\Route;
//Admin Controllers
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

//Administrator zone
Route::prefix('management')->group(function(){
	Route::get('/', [MainController::class, 'index'])->name('admin.index');
	Route::resource('/categories', CategoryController::class);
	Route::resource('/tags', TagController::class);
	Route::resource('/posts', PostController::class);
});
