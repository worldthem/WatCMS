<?php
	

namespace App\Outside\Modules\Cash\Controllers;
 

use App\Http\Controllers\Controller;
use App\Http\Controllers\VisitsController; 

class TestC extends Controller {
    
    public function index() {
        return view('theme::cach.home'); 
     }
 } 