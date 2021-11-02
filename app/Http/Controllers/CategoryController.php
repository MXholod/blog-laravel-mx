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
		//Get widgets for category
		if(!is_null($category)){
			$categoryWidgets = Category::find($category->id);//->get();
		}
		//Form an array of widgets where key is a 'title' and 'value' is a 'full_text'
		$category_widgets = $categoryWidgets->widgets->pluck('full_text', 'title');
		//The posts() method is from Category Model
		$posts = $category->posts()->orderBy('id', 'desc')->paginate(2);
		return view('site.categories.show', compact('category', 'posts', 'category_widgets'));
	}
}
