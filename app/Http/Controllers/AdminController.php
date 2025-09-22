<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        return view('admin.users.index'); // Corrected path
    }

    public function restaurants()
    {
        return view('admin.restaurants.index'); // Corrected path
    }

    public function orders()
    {
        return view('admin.orders.index'); // Corrected path
    }

    public function discounts()
    {
        return view('admin.deals.index'); // Corrected path
    }

    public function reviews()
    {
        return view('admin.reviews.index'); // Corrected path
    }
}
