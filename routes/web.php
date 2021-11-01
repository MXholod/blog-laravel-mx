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
use App\Http\Controllers\Admin\SearchController as SearchPostController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\PagesController as PagesHomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\LogoController;

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
Route::post('/post/{slug}',[PostHomeController::class, 'addComment'])->name('comment.add')->middleware('auth');
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
		//Search posts by title on the client side
		Route::get('/search',[SearchPostController::class, 'index'])->name('admin.posts.search');
		Route::resource('/categories', CategoryController::class);
		//XMLHttpRequest route. It sets widget
		Route::post('/categories/widget/widget_store', [CategoryController::class, 'store_widget'])->name('category.widget.store');
		Route::patch('/categories/widget/widget_update/{id}', [CategoryController::class, 'update_widget'])->name('category.widget.update');
		Route::delete('/categories/widget/widget_destroy/{id}', [CategoryController::class, 'destroy_widget'])->name('category.widget.destroy');
		Route::resource('/tags', TagController::class);
		Route::resource('/posts', PostController::class);
		//XMLHttpRequest route. CKEditor image store
		Route::post('/posts/image_store', [PostController::class, 'image_store'])->name('admin.image_upload.store');//XMLHttpRequest route. CKEditor image edit
		Route::post('/posts/image_edit', [PostController::class, 'image_edit'])->name('admin.image_upload.edit');
		//XMLHttpRequest route. Delete chosen comment of a post
		Route::delete('/posts/{id}/edit/{commentId}', [PostController::class, 'delete_post_comment'])->name('admin.post_comment.delete');
		//XMLHttpRequest route. It sets widget
		Route::post('/posts/widget/widget_store', [PostController::class, 'store_widget'])->name('post.widget.store');
		Route::patch('/posts/widget/widget_update/{id}', [PostController::class, 'update_widget'])->name('post.widget.update');
		Route::delete('/posts/widget/widget_destroy/{id}', [PostController::class, 'destroy_widget'])->name('post.widget.destroy');
		//Slider gallery
		Route::resource('/slider', SliderController::class);
		Route::resource('/pages', PagesController::class);
		//XMLHttpRequest route. It sets widget
		Route::post('/pages/widget_store', [PagesController::class, 'store_widget'])->name('widget.store');
		Route::patch('/pages/widget_update/{id}', [PagesController::class, 'update_widget'])->name('widget.update');
		Route::delete('/pages/widget_destroy/{id}', [PagesController::class, 'destroy_widget'])->name('widget.destroy');
		//XMLHttpRequest route. It stores and destroys logo
		Route::post('/logo', [LogoController::class, 'store'])->name('logo.store');
		Route::delete('/logo/{id}', [LogoController::class, 'destroy'])->name('logo.destroy');
		//XMLHttpRequest route. It sets logo visibility
		Route::patch('/logo/visibility', [LogoController::class, 'logo_visibility'])->name('logo.visibility');
		//XMLHttpRequest route. It sets logo size: small or medium
		Route::patch('/logo/size', [LogoController::class, 'logo_size'])->name('logo.size');
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

//Static pages. where 'pages' = 'slug|slug'
//Route::get('/{pages}',PagesHomeController::class)->name('pages')->where('pages', 'about-us|contacts|test');
Route::get('/{pages}',PagesHomeController::class)->name('pages');

