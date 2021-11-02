<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PagesController extends Controller
{
    //
	public function __invoke($pages){
		//request()->segment(1) or $pages to compare with 'about-us|contacts'
		$page = Page::where('slug',$pages)->get();
		//Get widgets for static pages
		if(!is_null($page)){
			$pageWidgets = Page::find($page[0]->id);//->get();
		}
		//Form an array of widgets where key is a 'title' and 'value' is a 'full_text'
		$pageWidgets = $pageWidgets->widgets->pluck('full_text', 'title');
		//
		$slug_exists = false;
		foreach($page as $page_prop){
			if($page_prop->slug == $pages){
				$slug_exists = true;
			}
		}
		if(!$slug_exists) abort(404);
		
		return view('site.pages.index', ['page' => $page, 'page_widgets' => $pageWidgets]);
	}
}
