<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Package that provides Slug
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
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
	
	public function posts(){
		return $this->belongsToMany(Post::class);
	}
}
