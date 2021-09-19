<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		//$tags = [1];
		$tags = Tag::paginate(2);
		$title = "Tag list";
		return view('admin.tags.index', compact('title','tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$title = "Tag creation";
		return view('admin.tags.create', ['title' => $title]);
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
		//Tag title
		$tagTitle = $request->input('title');
		//If validation is successful do mass filling
		Tag::create([
			'title' => $tagTitle
		]);
		//Flash message
		//$request->session()->flash('success', "Tag {$tagTitle} has been added");
		//Flash message another way 'with()' method
		return redirect()->route('tags.index')->with('success', "The '{$tagTitle}' has been added");
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
        $title = "Edit chosen tag";
		//Find a category to edit
		$tag = Tag::find($id);
		
		return view('admin.tags.edit', compact('title','tag'));
		
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
		//Tag title
		$tagTitle = $request->input('title');
		//Find a tag to edit
		$tag = Tag::find($id);
		//$tag->slug = null; //If we want to change the slug. Set to null, slug will be changed according to the title
		//Update
		$tag->update(['title' => $tagTitle]);
		
		return redirect()->route('tags.index')->with('success', "The '{$tagTitle}' has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find a tag to edit
		$tag = Tag::find($id);
		//Total post amount
		$totalTags = $tag->posts->count();
		//If tag doesn't use any post
		if($totalTags == 0){
			$tag->delete();
			//$tag->destroy($id); //Delete tag immediately
			return redirect()->route('tags.index')->with('success', "The '{$tag->title}' has been deleted");
		}else{
			//You can't delete these tags they are used with posts
			$tagsStr = $totalTags == 1 ? 'uses with '.$totalTags.' post' : 'uses with '.$totalTags.' posts';
			return redirect()->route('tags.index')->with('error', "The '{$tag->title}' '{$tagsStr}'");
		}
		
    }
}
