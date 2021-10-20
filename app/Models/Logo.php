<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;
	
	//For mass assignment
	protected $fillable = ['logo_img_display','logo_img','logo_title','logo_size','logo_height','logo_width'];
	
	//Use this method in View template for a post edit
	public function getLogoImage(){
		//Message is absent
		if(!$this->logo_img){
			return false;
		}
		return asset("downloads/{$this->logo_img}");
	}
}
