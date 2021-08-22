<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ejemplar extends Model
{
     protected $table = 'ejemplares';
     protected $primaryKey = 'id_ejemplar'; 
    //public $incrementing = false;
     protected $fillable = ['codigo','num_ejemplar','estado_ejemplar','book_id'];
}
