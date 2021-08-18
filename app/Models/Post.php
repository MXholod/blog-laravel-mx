<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Package that provides Slug
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
	
	//For mass assignment
	protected $fillable = ['title','content','description','category_id','thumbnail'];
	
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
	
	public function tags(){
		//Set data in the pivot table 'post_tag' withTimestamps() - created_at, updated_at
		return $this->belongsToMany(Tag::class)->withTimestamps();
	}
	
	public function category(){
		return $this->belongsTo(Category::class);
	}
	
	//Use this method in View template for a post edit
	public function getImage(){
		//Message is absent
		if(!$this->thumbnail){
			return false;
		}
		return asset("downloads/{$this->thumbnail}");
	}
}
