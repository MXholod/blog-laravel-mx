<?php

use Illuminate\Support\Facades\Route;
//Admin Controllers
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\UserController;

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
    return view('home');
})->name('home');

//Administrator zone
Route::prefix('management')->group(function(){
	//Administrator access middleware 'admin_panel_access'. It was registered in Kernel.php
	Route::middleware(['admin_panel_access'])->group(function () {
		Route::get('/', [MainController::class, 'index'])->name('admin.index');
		Route::resource('/categories', CategoryController::class);
		Route::resource('/tags', TagController::class);
		Route::resource('/posts', PostController::class);
		//XMLHttpRequest route. CKEditor image store
		Route::post('/posts/image_store', [PostController::class, 'image_store'])->name('admin.image_upload.store');//XMLHttpRequest route. CKEditor image edit
		Route::post('/posts/image_edit', [PostController::class, 'image_edit'])->name('admin.image_upload.edit');
	});
});

//Middleware RedirectIfAuthenticated was changed.If you are 'guest' you will be redirected to home() route.
//We cannot follow these routes if we are authenticated
Route::middleware(['guest'])->group(function(){
	//The form for user registration
	Route::get('/register', [UserController::class, 'create'])->name('register.create');
	Route::post('/register', [UserController::class, 'store'])->name('register.store');
	//Authentication
	Route::get('/login', [UserController::class, 'loginForm'])->name('login.create');
	Route::post('/login', [UserController::class, 'login'])->name('login');	
});

//Middleware 'auth' only for authenticated users
Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

