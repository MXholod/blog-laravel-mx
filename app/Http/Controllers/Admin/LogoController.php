<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;
use App\Http\Controllers\Admin\MainController;
//This Facade is for deleting images
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LogoController extends Controller
{
    //Creating new logo or replace previous one if exists
	public function store(Request $request){
		//Validation of parameters
		$request->validate([
			'logo_img_display' => 'required|integer', // 0 | 1
			'logo_title' => 'required|string',
			'logo_size' => 'required|string',
			'logo' => 'required|image|max:1000' //nullable - means it is not required, max:1000 - kilobytes - 1mb
		]);
		//dd($request->all());
		$logoId = $request->input('rewrite_logo');
		
		//If logo 'id' exists delete 'image' on disk and a row in DB
		if(isset($logoId)){//'rewrite_logo'
			$logoExisted = Logo::find($request->input('rewrite_logo'));
			//Try to delete a previous image
			Storage::disk('public')->delete($logoExisted->logo_img);
			//Delete row in DB
			$logoExisted->delete();
			//If current 'id' == 10 or bigger, reset AUTO_INCREMENT
			$logoId = intval($logoId);
			if($logoId >= 10){
				DB::statement("ALTER TABLE logos AUTO_INCREMENT = 1");
			}
		}
		
		//$data = $request->all();
		//Check if the image file has been loaded
		if($request->hasFile('logo')){
			//Path to save files: public/downloads/images/logo	it is set in config/filesystems.php
			$data['logo_img'] = $request->file('logo')->store("logo", 'public');
		}
		
		//Using the "getimagesize()" function available by default from PHP to get Width and Height of the image
		$img = getimagesize($request->file('logo'));
		$width = $img[0]; // getting the image width
		$height = $img[1]; // getting the image height
		if(!$width || !$height){
			//Flash message another way 'with()' method
			return redirect()->route('admin.index')->with('error', "The image width or height is incorrect");
		}
		
		$logo = new Logo();
			$logo->logo_img_display = $request->input('logo_img_display');
			$logo->logo_img = $data['logo_img'];
			$logo->logo_title = $request->input('logo_title');
			$logo->logo_size = $request->input('logo_size');
			$logo->logo_width = $width;
			$logo->logo_height = $height;
		$logo->save();
		//Redirecting To Controller Actions
		return redirect()->action([MainController::class, 'index']);
	}
	
	//Delete logo for the site
	public function destroy(Request $request, $id){
		//Convert to integer
		$logoId = intval($id);
		//If logo 'id' exists delete 'image' on disk and a row in DB
		if($logoId != 0){
			$logoExisted = Logo::find($logoId);
			//Try to delete a previous image
			Storage::disk('public')->delete($logoExisted->logo_img);
			//Delete row in DB
			$logoExisted->delete();
			//If current 'id' == 10 or bigger, reset AUTO_INCREMENT
			$logoId = intval($logoId);
			if($logoId >= 10){
				DB::statement("ALTER TABLE logos AUTO_INCREMENT = 1");
			}
			//Redirecting To Controller Actions
			return redirect()->action([MainController::class, 'index']);
		}
		//Flash message another way 'with()' method
		return redirect()->route('admin.index')->with('error', "The logo can't be deleted");
	}
	
}
