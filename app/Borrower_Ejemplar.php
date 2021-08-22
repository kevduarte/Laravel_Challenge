<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower_Ejemplar extends Model
{
     protected $table = 'borrowers_ejemplares';
     //protected $primaryKey = 'id_ejemplar'; 
    //public $incrementing = false;
     protected $fillable = ['detalle_prestamo','id_ejemplar','borrower_id'];
}
