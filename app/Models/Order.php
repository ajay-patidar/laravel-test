<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'invoice_number', 'total_amount', 'status',
    ];

    /**
     * Get the customer of the order.
     */
    public function customer(){
        return $this->belongsTo(Customer::class)->withDefault();
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
