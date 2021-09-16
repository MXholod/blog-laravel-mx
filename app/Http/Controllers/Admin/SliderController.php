<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Post;
//This Facade is for deleting images
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$title = "Slider items list";
		//Display only 5 images on the page at once
		$slider_items = Slider::with('post')->paginate(5);
		return view('admin.slider.index', compact('title', 'slider_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$title = "Slider item creation for a post";
		//Count all the posts. Their slugs can be attached to the slider 
		$totalPosts = Post::all()->count();
		//Taking posts that are not related to the slider
		//$sql = 'SELECT p.title AS title, p.slug AS slug FROM posts p INNER JOIN slider s ON s.post_slug != p.slug';
		$sql = 'SELECT slug, title FROM posts WHERE slug NOT IN (SELECT post_slug FROM slider)';
		$postsWithoutSlider = DB::select($sql);
		$posts = array();
		if(count($postsWithoutSlider)){
			//Create array where key is a 'slug' and value is a 'title'. Like in pluck() method
			foreach($postsWithoutSlider as $post){
				$posts[$post->slug] = $post->title;
			}
		}
		//Get only 'title' and 'id' from Posts table.
		//$posts = Post::pluck('title','slug')->all(); //Array as result where 'title' - value and 'slug' - key
		return view('admin.slider.create', ['title' => $title,  'totalPosts'=> $totalPosts, 'posts'=> $posts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		//Validation of parameters
		$request->validate([
			'title' => 'required',
			'description' => 'required',
			'post_slug' => 'required',
			'path_img' => 'required|image' //nullable - means it is not required
		]);
		//dd($request->all());
		$data = $request->all();
		//Check if the image file has been loaded
		if($request->hasFile('path_img')){
			$folderName = date('Y-m-d');
			//Path to save files: public/downloads/slider/2021-08-20	it is set in config/filesystems.php
			$data['path_img'] = $request->file('path_img')->store("slider/{$folderName}", 'public');
		}
		//Mass assignment
		$slider = Slider::create($data);
		//Slider title
		$sliderTitle = $request->input('title');
		//Flash message another way 'with()' method
		return redirect()->route('slider.index')->with('success', "The '{$sliderTitle}' has been added");
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
        //
		$slider = Slider::find($id);
		$posts = Post::pluck('title','slug')->all(); //Array as result where 'title' - value and 'slug' - key
        //
		$title = "Edit chosen slider";
		
		return view('admin.slider.edit', compact('title', 'slider','posts'));
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
			'p_slug' => 'required',
			'path_img' => 'nullable|image' //nullable - means it is not required
		]);
		//dd($request->all());
		$slider = Slider::find($id);
		//Remember the request 
		$data = $request->all();
		$data['post_slug'] = $request->input('p_slug');
		//Check if the image file has been loaded
		if($request->hasFile('path_img')){
			//Try to delete a previous image
			Storage::disk('public')->delete($slider->path_img);
			//After the deletion adds new one
			$folderName = date('Y-m-d');
			//Path to save files: public/downloads/images/2021-08-20	it is set in config/filesystems.php
			$data['path_img'] = $request->file('path_img')->store("slider/{$folderName}", 'public');
		}
		//Slider title
		$sliderTitle = $request->input('title');
		//Update
		$slider->update($data);
		//Flash message another way 'with()' method
		return redirect()->route('slider.index')->with('success', "The '{$sliderTitle}' has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		//Delete image and Slider Model and also when a post is deleted we have to delete Slider associated with it
		//Get the Slider by ID from DB
		$slider = Slider::find($id);
		//Check if the file exists
		if(Storage::disk('public')->exists($slider->path_img)) {//'file.jpg'
			Storage::disk('public')->delete($slider->path_img);
			//Delete Slider from DB
			$slider->delete();
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
		return redirect()->route('slider.index')->with('success', "The slider has been deleted");
    }
}
