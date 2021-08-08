<?php

use Illuminate\Support\Facades\Route;
//Admin Controllers
use App\Http\Controllers\Admin\MainController;

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
});
