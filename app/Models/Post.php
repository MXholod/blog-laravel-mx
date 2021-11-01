<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
//Package that provides Slug
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
	
	public function registerMediaConversions(Media $media = null): void
	{
	   $this->addMediaConversion('thumb')->width(400);
	}
	
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
	
	//For Slider Model to make 'One To One'
	public function slider(){
		return $this->belongsTo(Slider::class,'slug','post_slug');
	}
	
	//Set date format
	public function setPostDate(){
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');
	}
	
	//Post has many comments
	public function comments(){
		// Comment, 'foreign_key', 'local_key'
		return $this->hasMany(Comment::class, 'post_id', 'id');
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
