<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $table = 'manager';
     protected $primaryKey = 'manager_id'; 
    //public $incrementing = false;
     protected $fillable = ['manager_name','manager_position'];
}
