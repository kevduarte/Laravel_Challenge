<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
     protected $table = 'books';
     protected $primaryKey = 'book_id'; 
    //public $incrementing = false;
     protected $fillable = ['isbn','book_name','book_author','publication_date','book_status','category_id'];
}
