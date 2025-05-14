<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'order_item_id';
    //
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price'
    ];
}
