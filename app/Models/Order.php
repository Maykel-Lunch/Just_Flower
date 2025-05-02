<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    protected $fillable = [
        'order_id',
        'user_id',
        'gift_card_id',
        'order_date',
        'total_amount',
        'final_amount',
        'shipping_cost',
        'payment_status',
        'delivery_status',
    ];
}
