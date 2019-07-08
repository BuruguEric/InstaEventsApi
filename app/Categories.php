<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category';
    public $incrementing = false;
    protected $fillable = ['category','category_description','category_poster','created_at','updated_at'];
}