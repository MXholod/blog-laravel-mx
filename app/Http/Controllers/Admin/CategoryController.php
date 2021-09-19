<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		//$categories = [1];
		$categories = Category::paginate(2);
		$title = "Category list";
		return view('admin.categories.index', compact('title','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$title = "Category creation";
		return view('admin.categories.create', ['title' => $title]);
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
		$request->validate([
			'title' => 'required'
		]);
		//Category title
		$categoryTitle = $request->input('title');
		//If validation is successful do mass filling
		Category::create([
			'title' => $categoryTitle
		]);
		//Flash message
		//$request->session()->flash('success', "Category {$categoryTitle} has been added");
		//Flash message another way 'with()' method
		return redirect()->route('categories.index')->with('success', "The '{$categoryTitle}' has been added");
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
        $title = "Edit chosen category";
		//Find a category to edit
		$category = Category::find($id);
		
		return view('admin.categories.edit', compact('title','category'));
		
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
        //
		$request->validate([
			'title' => 'required'
		]);
		//Category title
		$categoryTitle = $request->input('title');
		//Find a category to edit
		$category = Category::find($id);
		//$category->slug = null; //If we want to change the slug. Set to null, slug will be changed according to the title
		//Update
		$category->update(['title' => $categoryTitle]);
		
		return redirect()->route('categories.index')->with('success', "The '{$categoryTitle}' has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find a category to edit
		$category = Category::find($id);
		//Total post amount
		$totalPosts = $category->posts->count();
		//If category hasn't any post
		if($totalPosts == 0){
			$category->delete();
			//$category->destroy($id); //Delete category immediately
			return redirect()->route('categories.index')->with('success', "The '{$category->title}' has been deleted");
		}else{
			//You can't delete these categories they have posts
			$postsStr = $totalPosts == 1 ? 'has '.$totalPosts.' post' : 'have '.$totalPosts.' posts';
			return redirect()->route('categories.index')->with('error', "The category '{$category->title}' '{$postsStr}'");
		}
    }
}
