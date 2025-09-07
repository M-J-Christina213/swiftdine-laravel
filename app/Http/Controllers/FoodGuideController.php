<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodGuideController extends Controller
{
    // Show the food guide page
    public function index()
    {
        return view('guide.index'); 
    }
}
