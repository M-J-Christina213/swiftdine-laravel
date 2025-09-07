<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;

class HomeController extends Controller
{
    // Display the home page
    public function index()
    {
        
        // Fetch all special offers (from your `deals` table)
    $deals = Deal::all();

    // Pass it to the view
    return view('home', compact('deals'));
    }
}
