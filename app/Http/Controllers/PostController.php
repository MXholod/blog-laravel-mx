<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Slider;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class PostController extends Controller
{
	//Amount of displayed comments
	private $commentsAmount = 5; 
    //
	public function index(){
		$sliders = DB::table('slider')->select('title','post_slug','path_img','description')->get();
		$posts = Post::with('category','tags')->orderBy('id', 'desc')->paginate(4);//->get();
		return view('site.posts.index', compact('sliders','posts'));
	}
	//
	public function show(Request $request, $slug){
		//If Ajax Request get only comments
		if($request->ajax()){
			//Get all last comments
			$post = Post::where('slug', $slug)->first();
			$comments = $post->comments()->orderBy('created_at', 'desc')->paginate($this->commentsAmount);
			return view('site.comments.comment_list', compact('comments'))->render();
		}else{//If Synchronous Request
			//Get requested 'post' or 404 error 
			$post = Post::where('slug', $slug)->firstOrFail();
			$totalComments = $post->comments()->count();
			//dd($totalComments);
			$comments = $post->comments()->orderBy('created_at', 'desc')->paginate($this->commentsAmount);
			//We increment amount of views and update the post
			$post->views += 1;
			$post->update();
			return view('site.posts.show', compact('post', 'comments', 'totalComments'));
		}
	}
	
	public function addComment(Request $request, $slug){
		//Try to add a comment by Ajax
		if($request->ajax()){
			//If comment is absent
			if(is_null($request->input('comment'))){
				return response()->json([
					"commentAbsent" => true
				]);
			}
			//Write comment into the database
			$comment = new Comment;
				$comment->user_id = $request->input('user_id');
				$comment->post_id = $request->input('post_id');
				$comment->comment = $request->input('comment');
			$comment->save();
			//Get all last comments
			$post = Post::where('slug', $slug)->first();
			$comments = $post->comments()->orderBy('created_at', 'desc')->paginate($this->commentsAmount);
			return view('site.comments.comment_list', compact('comments'))->render();
		}
	}
}
