<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Allow mass assignment for these columns
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'fulfillment',
        'payment_method',
        'subtotal',
        'tax',
        'delivery_fee',
        'total',
        'status',
        'user_id',
        'restaurant_id',
    ];

    /**
     * The user who placed the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The restaurant associated with the order
     */
    // Removed duplicate restaurant method

    /**
     * The items in this order
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Payment details for this order
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function restaurant()
{
    return $this->belongsTo(Restaurant::class);
}

}
