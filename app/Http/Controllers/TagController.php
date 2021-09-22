<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
	public function show($slug){
		//Get requested 'tag' or 404 error
		$tag = Tag::where('slug', $slug)->firstOrFail();
		//The posts() method is from Tag Model
		$posts = $tag->posts()->orderBy('id', 'desc')->paginate(2);
		return view('site.tags.show', compact('tag','posts'));
	}
}
