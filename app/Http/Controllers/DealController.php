<?php

namespace App\Http\Controllers;

use App\Models\Deal;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::all();
        return view('deals.index', compact('deals'));
    }
}
