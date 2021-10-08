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
}
