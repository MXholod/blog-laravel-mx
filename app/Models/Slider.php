<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slider';
	
	protected $fillable = ['title','description','post_slug','path_img'];
	
	//Use this method in View template for a slider edit
	public function getImage(){
		//Message is absent
		if(!$this->path_img){
			return false;
		}
		return asset("downloads/{$this->path_img}");
	}
	
	//For Post Model to make 'One To One'
	public function post(){
		return $this->hasOne(Post::class,'slug','post_slug');
	}
}
