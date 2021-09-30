<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Page;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        //View::composer('profile', ProfileComposer::class); // use App\View\Composers\ProfileComposer;

		$pages = Page::all();
		$header = array();
		$footer = array();
		foreach($pages as $page){
			//To the header
			if($page->display && ($page->display_place == 0)){
				array_push($header, ['title' => $page->title, 'slug' => $page->slug]);
			}
			//To the footer
			if($page->display && ($page->display_place == 1)){
				array_push($footer, ['title' => $page->title, 'slug' => $page->slug]);
			}
		}
        // Header template. Using closure based composers...
        View::composer('site.parent_templates.header_template', function ($view) use ($header) {
            //
			$view->with('header_links', $header);
        });
		// Footer template. Using closure based composers...
        View::composer('site.parent_templates.footer_template', function ($view) use ($footer){
            //
			$view->with('footer_links', $footer);
        });
    }
}
