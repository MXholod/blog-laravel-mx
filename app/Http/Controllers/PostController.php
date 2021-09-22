<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Slider;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //
	public function index(){
		$sliders = DB::table('slider')->select('title','post_slug','path_img','description')->get();
		$posts = Post::with('category','tags')->orderBy('id', 'desc')->paginate(2);//->get();
		return view('site.posts.index', compact('sliders','posts'));
	}
	//
	public function show($slug){
		
		//Get requested 'post' or 404 error 
		$post = Post::where('slug', $slug)->firstOrFail();
		//We increment amount of views and update the post
		$post->views += 1;
		$post->update();
		return view('site.posts.show', compact('post'));
	}
}
