<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class OrderItem extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'order_id',
        'menu_id',
        'name',
        'description',
        'price',
        'quantity',
        'image_path',
    ];

    /**
     * The order this item belongs to
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * The menu item associated with this order item
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
