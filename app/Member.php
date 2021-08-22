<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
     protected $table = 'members';
     protected $primaryKey = 'member_id'; 
    //public $incrementing = false;
     protected $fillable = ['member_name','member_address'];
}
