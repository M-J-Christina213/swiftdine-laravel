<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        Reservation::create($request->all());
        return redirect()->route('home')->with('success', 'Reservation created!');
    }
}
