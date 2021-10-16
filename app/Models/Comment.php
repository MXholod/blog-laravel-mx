<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;
	
	//For mass assignment
	protected $fillable = ['user_id','post_id','comment'];
	
	//Get post
	public function post(){
		return $this->belongsTo(Post::class, 'post_id', 'id');
	}
	//Get user
	public function user(){
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
	//Set date format
	public function setCommenttDate(){
		return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');
	}
	//Creating the initial part of the comment
	public function initialPartOfComment(){
		$minLimitCharacters = 15;
		$maxLimitCharacters = 40;
		//
		$commentLength = strlen($this->comment);
		
		if($commentLength == 0){
			return 'Comment text is absent';
		}else if($commentLength > 0 && ($minLimitCharacters >= $commentLength)){
			return $this->comment.' ...';
		}else{//Here is more characters than in $commentLength
			$percentage = $commentLength * 30 / 100;//30% from full length of comment. 30% = 50 characters
			$roundedCommentLength = round($percentage, 0, PHP_ROUND_HALF_UP);
			//x <= 15
			if($roundedCommentLength <= $minLimitCharacters){
				return substr($this->comment, 0, $minLimitCharacters).' ...';
				//x > 15 && x <= 40
			}else if($roundedCommentLength > $minLimitCharacters){
				//Here more than 50 characters cut first 40
				return substr($this->comment, 0, $maxLimitCharacters).' ...';
			}
		}
	}
}
