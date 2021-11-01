<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//Package that provides Slug
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;

class Page extends Model
{
    use HasFactory;
	
	//For mass assignment
	protected $fillable = ['title','content','thumbnail','display','display_place'];
	
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
	
	//Use this method in View template for a post edit
	public function getImage(){
		//Message is absent
		if(!$this->thumbnail){
			return false;
		}
		return asset("downloads/{$this->thumbnail}");
	}
	
	//Set date format
	public function setPostDate(){
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');
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
