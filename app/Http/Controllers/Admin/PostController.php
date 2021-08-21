<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

//This Facade is for deleting images
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		//$posts = Post::paginate(10);
		//These are from Post Model 'category', 'tag'
		$posts = Post::with('category', 'tags')->paginate(10);
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
		//dd();
		
		//Tag title
		$postTitle = $request->input('title');
		//Flash message
		//$request->session()->flash('success', "Post {$postTitle} has been added");
		//Flash message another way 'with()' method
		return redirect()->route('posts.index')->with('success', "The '{$postTitle}' has been added");
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
    public function edit($id)
    {
		$post = Post::find($id);
		//Get only 'title' and 'id' from Categories table. Where 'id' - from 'category_id' Posts table
		$categories = Category::pluck('title','id')->all(); //Array as result where 'title' - value and 'id' - key 
		$tags = Tag::pluck('title','id')->all(); //Array as result where 'title' - value and 'id' - key
        //
		$title = "Edit chosen post";
		
		return view('admin.posts.edit', compact('title', 'post', 'categories', 'tags'));
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
		//Find a post to delete
		$post = Post::find($id);
		//Delete all bound tags to the current post from the pivot table 'post_tag'
		$post->tags()->sync([]);
		//Try to delete a previous image
		Storage::disk('public')->delete($post->thumbnail);
		//Delete post itself
		$post->delete();
		return redirect()->route('posts.index')->with('success', "The post has been deleted");
    }
}
