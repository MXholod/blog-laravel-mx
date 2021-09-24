<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Enable Bootstrap pagination
		Paginator::useBootstrap();
		//Using View Composer. Pass data into the Sidebar template using callback function 
		view()->composer('site.parent_templates.main_sidebar_template', function($view){
			//Count amount of views of each post then group these posts with appropriate categories. As a result, we received a maximum of 10 categories that have the most views in posts
			$categories = DB::select('SELECT c.title, c.slug, p.category_id, SUM(p.views) AS amount FROM posts p INNER JOIN categories c ON c.id = p.category_id GROUP BY p.category_id ORDER BY amount DESC LIMIT 10');
			$popular_categories = [];
			$popular_categories2 = [];
			$i = 0;
			//Divide in two portions. We have to columns in view
			foreach($categories as $category){
				if($i >= 0 && $i < 5){
					$popular_categories[$category->slug] = $category->title;
				}
				if($i >= 5 && $i < 10){
					$popular_categories2[$category->slug] = $category->title;
				}
				$i++;
			}
			$view->with('popular_categories', $popular_categories)->with('popular_categories2', $popular_categories2);
		});
		//Using View Composer. Pass data into the Footer template using callback function 
		view()->composer('site.parent_templates.footer_template', function($view){
			//Popular posts
			$popular_posts = Post::orderBy('views', 'desc')->limit(6)->get();
			//Recent posts
			$recent_posts = Post::orderBy('created_at', 'desc')->limit(6)->get();
			$view->with('popular_posts', $popular_posts)->with('recent_posts', $recent_posts);
		});
    }
}
