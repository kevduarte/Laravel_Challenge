<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category_id';
     protected $primaryKey = 'category_id'; 
    //public $incrementing = false;
     protected $fillable = ['category_name','category_description'];
}
