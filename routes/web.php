<?php

use Illuminate\Support\Facades\Route;
//Admin Controllers
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\TagController as TagHomeController;
use App\Http\Controllers\PostController as PostHomeController;
use App\Http\Controllers\CategoryController as CategoryHomeController;
use App\Http\Controllers\SearchController;

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



/*Route::get('/', function () {
    return view('home');
})->name('home');*/

//Home page
Route::get('/',[PostHomeController::class, 'index'])->name('home');
Route::get('/tag/{slug}',[TagHomeController::class, 'show'])->name('tags.single');
Route::get('/post/{slug}',[PostHomeController::class, 'show'])->name('posts.single');
Route::get('/category/{slug}',[CategoryHomeController::class, 'show'])->name('categories.single');

//Slider on main page. It shows a list of certain posts
//Route::get('/slider', [SliderController::class, 'index'])->name('slider_post_list.index');
//Search posts by title on the client side
Route::get('/search',[SearchController::class, 'index'])->name('search');

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
		//Slider gallery
		Route::resource('/slider', SliderController::class);
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

