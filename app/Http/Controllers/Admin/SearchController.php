<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    //
	public function index(Request $request){
		$request->validate([
			'search' => 'required'
		]);
		$title = "List of found posts";
		$search = $request->search;
		$posts = Post::where('title', 'LIKE', "%{$search}%")->paginate(5);
		
		return view('admin.search.index', compact('title', 'search', 'posts'));
	}
}
