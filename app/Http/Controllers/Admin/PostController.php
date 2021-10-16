<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Slider;
use App\Models\Comment;

use Illuminate\Support\Facades\DB;

//This Facade is for deleting images
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
	private $commentsAmount = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get rows from 'media' table to delete them. These images did not apply to posts. The condition is:
		//'post_media.post_id' != 'media.model_id' or 'post_media.image_name' != 'media.name' 
		//$query = "SELECT m.id, m.name FROM media m INNER JOIN post_media p ON p.post_id != m.model_id OR p.image_name != m.name OR p.media_model_id != m.id";
		$query = "SELECT id, model_id FROM media WHERE id NOT IN (SELECT media_model_id FROM post_media)";
		$mediaToDelete = DB::select($query);
		if(count($mediaToDelete)){
			//Create string '$ids' from DB query like: '23,24,27' 
			$ids = '';
			foreach($mediaToDelete as $mediaDel){
				$ids .= $mediaDel->id.',';
			}
			//Remove the last comma in string from DB query of rows to delete
			$ids = rtrim($ids, ',');
			//Let's remove the useless row(s) from 'media' table
			$deleted = DB::delete("DELETE FROM media WHERE id IN ($ids)");
			//All folders from the 'spatie' storage folder
			$spatieAllFolders = [];
			$directories = Storage::disk('spatie')->listContents();
			foreach($directories as $dirToDelete){
				array_push($spatieAllFolders, $dirToDelete['path']);
			}
			//Find directories to remove according to '$ids' as array. 'array_intersect' - Computes the convergence of arrays
			$dirToDel = array_intersect($spatieAllFolders, explode(",", $ids));
			//Go through the loop to delete folders
			foreach($dirToDel as $dir){
				//Delete all folders in 'spatie' storage folder
				Storage::deleteDirectory('spatie/'.$dir);
			}
		}
		//$posts = Post::paginate(10);
		//These are from Post Model 'category', 'tag', 'slider'
		$posts = Post::with('category', 'tags', 'slider','comments')->paginate(10);
		$title = "Post list";
		return view('admin.posts.index',compact('title','posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$title = "Post creation";
		//Get only 'title' and 'id' from Categories table. Where 'id' - from 'category_id' Posts table
		$categories = Category::pluck('title','id')->all(); //Array as result where 'title' - value and 'id' - key 
		$tags = Tag::pluck('title','id')->all(); //Array as result where 'title' - value and 'id' - key 
		return view('admin.posts.create', ['title' => $title, 'categories'=> $categories, 'tags'=> $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation of parameters
		$request->validate([
			'title' => 'required',
			'description' => 'required',
			'content' => 'required',
			'category_id' => 'required|integer',
			//tags[] - is not required
			'thumbnail' => 'nullable|image' //nullable - means it is not required
		]);
		//Create array from JSON (input hidden field 'postImages')
		$postImages = json_decode($request->postImages);
		//dd($postImages);
		$imagesToInsert = [];
		if(count($postImages)){
			//Get the future 'id' of the Post Model
			$query = "SELECT TABLE_NAME, AUTO_INCREMENT AS id FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'laravelblog' AND TABLE_NAME = 'posts'";
			$model_id = DB::select($query);
			foreach($postImages as $image){
				array_push($imagesToInsert, array( 
					"post_id" => $model_id[0]->id,
					"media_model_id" => $image->imgId,
					"image_name" => $image->imgName
				));
			}
			//Save all CKEditor images into DB [ ["post_id" => '4', "image_name" => 'Temple', "media_model_id" => 23], ... ]
			DB::table('post_media')->insert($imagesToInsert);
		}
		$data = $request->all();
		//Check if the image file has been loaded
		if($request->hasFile('thumbnail')){
			$folderName = date('Y-m-d');
			//Path to save files: public/downloads/images/2021-08-20	it is set in config/filesystems.php
			$data['thumbnail'] = $request->file('thumbnail')->store("images/{$folderName}", 'public');
		}
		$post = Post::create($data);
		//Set tags to the post
		$post->tags()->sync($request->tags);
		
		//Tag title
		$postTitle = $request->input('title');
		//Flash message
		//$request->session()->flash('success', "Post {$postTitle} has been added");
		//Flash message another way 'with()' method
		return redirect()->route('posts.index')->with('success', "The '{$postTitle}' has been added");
    }
	/**
     * Upload images by XMLHttpRequest.
     *
     * @param  int  $request
     * @return \Illuminate\Http\Response
     */
	public function image_store(){
		//Get the future 'id' of the Post Model
		$query = "SELECT TABLE_NAME, AUTO_INCREMENT AS id FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'laravelblog' AND TABLE_NAME = 'posts'";
		$model_id = DB::select($query);
		
		$post = new Post();
		if(is_array($model_id)){
			$post->id = $model_id[0]->id;
		}
		$post->exists = true;
		//Upload is a field of FormData to transfer the file from 'scripts_ckeditor.blade.php' and 'url' also from here
		$image = $post->addMediaFromRequest('upload')->toMediaCollection('images');
		return response()->json([
			'url' => $image->getUrl('thumb'),
			'imageId' => $image->id
		]);
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
		//If Ajax Request get only comments
		if($request->ajax()){
			//Get all last comments
			$post = Post::where('id', $id)->first();
			$comments = $post->comments()->orderBy('created_at', 'desc')->paginate($this->commentsAmount);
			return view('admin.comments.comment_list', compact('comments', 'id'))->render();
		}else{//If Synchronous Request
			$post = Post::find($id);
			//Get only 'title' and 'id' from Categories table. Where 'id' - from 'category_id' Posts table
			$categories = Category::pluck('title','id')->all(); //Array as result where 'title' - value and 'id' - key 
			$tags = Tag::pluck('title','id')->all(); //Array as result where 'title' - value and 'id' - key
			//Get a portion of 5 comments to the current post
			$comments = $post->comments()->orderBy('created_at', 'desc')->paginate($this->commentsAmount);
			$title = "Edit chosen post";
			
			return view('admin.posts.edit', compact('title', 'post', 'categories', 'tags', 'comments'));
		}
    }
	
	public function image_edit(Request $request){
		if($request->isMethod('post')){
			if($request->input('post_id')){
				$post = new Post();
				$post->id = $request->input('post_id');
				$post->exists = true;
				//Upload is a field of FormData to transfer the file from 'scripts_ckeditor.blade.php' and 'url' also from here
				$image = $post->addMediaFromRequest('upload')->toMediaCollection('images');
				return response()->json([
					'url' => $image->getUrl('thumb'),
					'imageId' => $image->id
				]);
			}
		}
		return response()->json([
			'url' => "",
			'imageId' => ""
		]);
	}
	/**
     * It leaves only unique elements in array by specified key
     *
     * @param  array  $array
     * @param  string  $key
     * @return array
     */
	private function unique_multidim_array($array, $key) {
		$temp_array = array();
		$i = 0;
		$key_array = array();
	   
		foreach($array as $val) {
			if (!in_array($val[$key], $key_array)) {
				$key_array[$i] = $val[$key];
				$temp_array[$i] = $val;
			}
			$i++;
		}
		return $temp_array;
	}
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validation of parameters
		$request->validate([
			'title' => 'required',
			'description' => 'required',
			'content' => 'required',
			'category_id' => 'required|integer',
			//tags[] - is not required
			'thumbnail' => 'nullable|image' //nullable - means it is not required
		]);
		//Get all images from the content place, which are related to the post
		$imagesRelatedToPost = DB::select('SELECT post_id, image_name, media_model_id FROM post_media WHERE post_id = ?', [$id]);
		//Create array from JSON (input hidden field 'postImages')
		$postImages = json_decode($request->postImages);
		//If post has at least one image. We must add new or update existed
		if(count($postImages) && count($imagesRelatedToPost) !== 0){
			//Compare images from 'post_media' table and chosen from View
			$imagesToInsert = [];
			//If images are already applied to the post skip them
			foreach($postImages as $postImg){
				foreach($imagesRelatedToPost as $tableImg){
					if($tableImg->post_id == $id && $postImg->imgId !== $tableImg->media_model_id){
						array_push($imagesToInsert, array('media_model_id' => $postImg->imgId, 'image_name' => $postImg->imgName, "post_id" => $id ));
					}
				}
			}
			//Insert if the post got new images
			if(count($imagesToInsert)){
				$imagesToInsert = $this->unique_multidim_array($imagesToInsert, "media_model_id");
				DB::table('post_media')->insert($imagesToInsert);
			}
		}else{
			//First time insert images the 'post_media' table is still empty. Get images from the form
			$arrImagesToUpdate = [];
			foreach($postImages as $image){
				array_push($arrImagesToUpdate, array(
					"post_id" => $id, 
					"media_model_id" => $image->imgId,
					"image_name" => $image->imgName
				));
			}
			//Insert all CKEditor images into DB [ ["post_id" => '4', "image_name" => 'Temple', "media_model_id" => 23], ... ]
			DB::table('post_media')->insert($arrImagesToUpdate);
		}
		
		$post = Post::find($id);
		//Remember the request 
		$data = $request->all();
		
		//Check if the image file has been loaded
		if($request->hasFile('thumbnail')){
			//Try to delete a previous image
			Storage::disk('public')->delete($post->thumbnail);
			//After the deletion adds new one
			$folderName = date('Y-m-d');
			//Path to save files: public/downloads/images/2021-08-20	it is set in config/filesystems.php
			$data['thumbnail'] = $request->file('thumbnail')->store("images/{$folderName}", 'public');
		}
		
		//Tag title
		$tagTitle = $request->input('title');
		//Find a tag to edit
		
		//Update
		$post->update($data);
		//Set tags to the post
		$post->tags()->sync($request->tags);
		
		return redirect()->route('posts.index')->with('success', "The '{$tagTitle}' has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		//Get all folder names from 'spatie' folder
		$mediaToDelete = DB::select("SELECT media_model_id FROM post_media WHERE post_id = $id");
		
		if(count($mediaToDelete)){
			//Create string '$ids' from DB query like: '23,24,27' 
			$ids = '';
			foreach($mediaToDelete as $mediaDel){
				$ids .= $mediaDel->media_model_id.',';
			}
			//Remove the last comma in string from DB query of rows to delete
			$ids = rtrim($ids, ',');
			//Delete all images from 'post_media' table
			DB::delete("DELETE FROM post_media WHERE post_id = $id");
			//All folders from the 'spatie' storage folder
			$spatieAllFolders = [];
			$directories = Storage::disk('spatie')->listContents();
			foreach($directories as $dirToDelete){
				array_push($spatieAllFolders, $dirToDelete['path']);
			}
			//Find directories to remove according to '$ids' as array. 'array_intersect' - Computes the convergence of arrays
			$dirToDel = array_intersect($spatieAllFolders, explode(",", $ids));
			//Go through the loop to delete folders
			foreach($dirToDel as $dir){
				//Delete all folders in 'spatie' storage folder
				Storage::deleteDirectory('spatie/'.$dir);
			}
		}
		//Find a post to delete
		$post = Post::find($id);
		//If the slider is attached
		if(!is_null($post->slider)){
			//If post has a slider we must delete this slider with its image on the disk
			if($post->slider->post_slug == $post->slug){
				//dd($post->slider->path_img);
				//$slider = Slider::where('post_slug','=',$post->slug)->get();
				//Check if the file exists
				if(Storage::disk('public')->exists($post->slider->path_img)) {//'file.jpg'
					Storage::disk('public')->delete($post->slider->path_img);
					//Delete Slider from DB
					$post->slider->delete();
				}
				//Find all empty directories and delete them
				$directories = Storage::disk('public')->directories('slider');
				foreach($directories as $dir){
					//Find all files in current directory
					$files = Storage::disk('public')->files($dir);
					//If directory is empty delete it
					if(!count($files)){
						//Delete empty directory
						Storage::disk('public')->deleteDirectory($dir);
					}
				}
			}
		}
		//Delete all bound tags to the current post from the pivot table 'post_tag'
		$post->tags()->sync([]);
		//Try to delete a previous image
		Storage::disk('public')->delete($post->thumbnail);
		//Delete post itself
		$post->delete();
		return redirect()->route('posts.index')->with('success', "The post has been deleted");
    }
	
	//Delete chosen comment of the post with AJAX
	public function delete_post_comment(Request $request, $id, $commentId){
		//Check if AJAX
		if($request->ajax()){
			if($request->isMethod('delete')){
				$commId = $request->input('comment_id');
				$userId = $request->input('user_id');
				$post_id = $request->input('post_id');
				//Find a comment
				$comment = Comment::find($commId);
				//Delete the comment
				$comment->delete();
				//Get a post by 'id'
				$post = Post::where('id', $post_id)->first();
				//Get last five comments related to the post
				$comments = $post->comments()->orderBy('created_at', 'desc')->paginate($this->commentsAmount);
				//Compile view with comments after the one was deleted
				return view('admin.comments.comment_list', compact('comments', 'id'))->render();
			}else{
				return response()->json([
					'data' => "Bad request"
				]);
			}
		}
	}
}
