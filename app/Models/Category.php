<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Package that provides Slug
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory;
	
	protected $fillable = ['title'];
	
	//Use this trait for Slug
	use Sluggable;
	/**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
	
	//Category to Posts - One to Many
	public function posts(){
		return $this->hasMany(Post::class);
	}
	
	/**
     * Get all of the widgets for the page.
     */
    public function widgets()
    {
		//Many To Many (Polymorphic)
        return $this->morphToMany(Widget::class, 'widgetable');
    }
}
