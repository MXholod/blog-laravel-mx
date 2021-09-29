<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
//This Facade is for deleting images
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$pages = Page::paginate(5);
		$title = "Pages list";
		return view('admin.pages.index', compact('title', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$title = "Page creation";
		return view('admin.pages.create', ['title' => $title]);
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
			'content' => 'required',
			'display' => 'required',
			'display_place' => 'required',
			'thumbnail' => 'nullable|image' //nullable - means it is not required
		]);
		$data = $request->all();
		//Check if the image file has been loaded
		if($request->hasFile('thumbnail')){
			$folderName = date('Y-m-d');
			//Path to save files: public/downloads/images/2021-08-20	it is set in config/filesystems.php
			$data['thumbnail'] = $request->file('thumbnail')->store("images/{$folderName}", 'public');
		}
		$page = Page::create($data);
		$pageTitle = $request->input('title');
		//Flash message
		//$request->session()->flash('success', "Post {$postTitle} has been added");
		//Flash message another way 'with()' method
		return redirect()->route('pages.index')->with('success', "The '{$pageTitle}' has been added");
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
		$page = Page::find($id);
		
		$title = "Edit chosen page";
		return view('admin.pages.edit', compact('title', 'page'));
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
			'content' => 'required',
			'display' => 'required',
			'display_place' => 'required',
			'thumbnail' => 'nullable|image' //nullable - means it is not required
		]);
		//dd($request->all());
		$page = Page::find($id);
		//Remember the request 
		$data = $request->all();
		
		//Check if the image file has been loaded
		if($request->hasFile('thumbnail')){
			//Try to delete a previous image
			Storage::disk('public')->delete($page->thumbnail);
			//After the deletion adds new one
			$folderName = date('Y-m-d');
			//Path to save files: public/downloads/images/2021-08-20	it is set in config/filesystems.php
			$data['thumbnail'] = $request->file('thumbnail')->store("images/{$folderName}", 'public');
		}
		
		$title = $request->input('title');
		
		//Update
		$page->update($data);
		
		return redirect()->route('pages.index')->with('success', "The '{$title}' has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$page = Page::find($id);
		if(Storage::disk('public')->exists($page->thumbnail)) {
			//Try to delete a previous image
			Storage::disk('public')->delete($page->thumbnail);
			//Find all empty directories and delete them
			$directories = Storage::disk('public')->directories('images');
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
		//Delete page itself
		$page->delete();
		return redirect()->route('pages.index')->with('success', "The page has been deleted");
    }
}
