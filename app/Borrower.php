<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
     protected $table = 'borrowers';
     protected $primaryKey = 'borrower_id'; 
    //public $incrementing = false;
     protected $fillable = ['start_date','end_date','borrower_status','manager_id','member_id'];
}
