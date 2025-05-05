<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $primaryKey = 'order_id';
    
    protected $fillable = [
        'order_id',
        'user_id',
        'gift_card_id',
        'total_amount',
        'final_amount',
        'payment_status',
        'delivery_status',
        'received_date',
        'confirmation_photo',
    ];

    // Exclude order_date from being mass assignable
    protected $guarded = ['order_date'];
}
