<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Slider;
use App\Models\Page;
use App\Models\Logo;

class MainController extends Controller
{
    //
	public function index(){
		
		$title = "Main admin page";
		$categories = Category::all();
		$posts = Post::all();
		$tags = Tag::all();
		$sliders = Slider::all();
		$pages = Page::all();
		//Get the site logo
		$logo = Logo::all();
		$logo = $logo[0] ?? $logo;
		return view('admin.index', [
			'title' => $title,
			'categories'=> $categories,
			'posts' => $posts,
			'tags' => $tags,
			'sliders' => $sliders,
			'pages' => $pages,
			'logo' => $logo //Always passes the first row of the table
		]);
	}
}
