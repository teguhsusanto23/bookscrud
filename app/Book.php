<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Book extends Model
{
    //
    protected $fillable = ['id','title','author','isbn','publish','category_id'];
    public function category()
    {
    	return $this->belongsTo('App\Category','category_id','id')->withDefault(['category']);
    }
}

