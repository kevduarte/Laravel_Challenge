<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePage extends Controller
{
    public function homepage(){
      return view ('welcome');
    }
}
