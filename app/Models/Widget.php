<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','full_text'];
	
	/**
     * Get all of the pages that are assigned this widget.
     */
    public function pages()
    {
		//Many To Many (Polymorphic)
        return $this->morphedByMany(Page::class, 'widgetable');
    }
	/**
     * Get all of the pages that are assigned this widget.
     */
    public function posts()
    {
		//Many To Many (Polymorphic)
        return $this->morphedByMany(Post::class, 'widgetable');
    }
}
