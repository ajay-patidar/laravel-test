<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'product_id', 'quantity',
    ];

    /**
     * Get the product of the order item.
     */
    public function product(){
        return $this->belongsTo(Product::class)->withDefault();
    }
}
