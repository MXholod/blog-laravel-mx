<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
	public function show($slug){
		//Get requested 'category' or 404 error
		$category = Category::where('slug', $slug)->firstOrFail();
		//The posts() method is from Category Model
		$posts = $category->posts()->orderBy('id', 'desc')->paginate(2);
		return view('site.categories.show', compact('category', 'posts'));
	}
}
