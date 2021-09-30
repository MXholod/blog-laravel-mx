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
		//
		$slug_exists = false;
		foreach($page as $page_prop){
			if($page_prop->slug == $pages){
				$slug_exists = true;
			}
		}
		if(!$slug_exists) abort(404);
		
		return view('site.pages.index', ['page' => $page]);
	}
}
